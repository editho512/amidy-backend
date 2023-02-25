<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Services\SortService;
use App\Services\PaymentService;
use App\Services\PaginationService;
use App\Http\Requests\Order\CreateOrderRequest;

class OrderController extends Controller
{

    public function index(Request $request, PaginationService $paginationService, SortService $sortService){
        $orders = Order::with(["user"]);

        // verify if it's for specific user
        $orders->when(isset($request->user_id), function($order) use ($request){
            return $order->where("user_id", $request->user_id);
        });

        // search the orders
        $orders->when(
            $request->search && $request->search != "",
            function ($query) use ($request) {
                return $query->where('reference', 'like', '%' . $request->search . '%');
            }
        );

        // sort the products
        $orders->when($request->sortBy, function ($query) use ($request, $sortService) {
            $sorts = json_decode($request->sortBy);
            return $sortService->sort($query, $sorts);
        });

        // paginate the orders
        if ($request->page) {
            $orders = $paginationService->paginate($orders, ["page" => $request->page]);
            return [
                "data" => $orders->get(),
                "options" => $paginationService->getOptions()
            ];
        }

        return $orders->get();
    }

    public function store(CreateOrderRequest $request){
        if($request->order){
            $order = Order::create([
                "status" => 0,
                "user_id" => auth()->user()->id
            ]);

            $order->generateReference();
            foreach ($request->order as $key => $value) {
                $product = Product::find($value["id"]);
                OrderProduct::create([ "order_id" => $order->id,  "product_id" => $value["id"], "quantity" => $value["quantity"], "price" => $product->price, "tva" => $product->tva]);
            }

            return response(["status" => "success", "data" => Order::with(['products'])->find($order->id)]);
        }
    }

    public function edit(Order $order){

        return Order::with(['products.photos'])->find($order->id);
    }

    public function pay(Request $request, Order $order){

        if($request->paymentMethod == 0 ){
            $order->status = 1;
        }{
            $payment = new PaymentService(intval($request->paymentMethod));

            $creditCard = $request->creditCard;
            $payment->setCustomer(
                [
                    "card" => array(
                        "number" => $creditCard["number"],
                        "exp_month" => $creditCard["month"],
                        "exp_year" => $creditCard["year"],
                        "cvc" => $creditCard["cvv"]
                    )
                ]
            );

            $payment->SetCharge([
                "amount" => $order->total_amount() * 100,
                "currency" => "usd",
                "description" => "order: " . $order->reference . " customer: ". auth()->user()->name
            ]);

            $charge = $payment->pay();

            if(isset($charge["id"])) $order->payments()->create(
                [
                    "payment_method" => intval($request->paymentMethod),
                    "amount" => $charge["amount"],
                    "attributes" => json_encode($charge)
                ]
            );

            $order->status = 2;
        }

        $order->save();
        return response(["status" => "success", "data" => Order::with(['products'])->find($order->id)]);
    }

    public function deliver(Order $order){
        $order->status = 3;
        $order->update();
        return $order;
    }
}
