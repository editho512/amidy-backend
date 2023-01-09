<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\SortService;
use App\Services\UploadService;
use App\Services\PaginationService;
use App\Http\Requests\Product\CreatePriceRequest;
use App\Http\Requests\Product\CreateStockRequest;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{

    public function index(Request $request, PaginationService $paginationService, SortService $sortService){


        $products = Product::with(['photos']);

        // verify if categorie is setted
        if($request->category){
            // get all categories id and put it in an array
            $categories =  [];
            foreach (json_decode($request->category) as $key => $value) {
                array_push($categories, $value->id);
            }

            if(count($categories) > 0) $products->getPerCategory($categories);
        }

        // verify if tags is setted
        if ($request->tag) {
            // get all categories id and put it in an array
            $tags =  [];
            foreach (json_decode($request->tag) as $key => $value) {
                array_push($tags, $value->id);
            }

            if (count($tags) > 0) $products->getPerTag($tags);
        }

        // sort the products
        $products->when($request->sortBy, function ($query) use ($request, $sortService) {
            $sorts = json_decode($request->sortBy);
            return $sortService->sort($query, $sorts);
        });

        // search the products
        $products->search($request->search);

        // paginate the categories
        if ($request->page) {
            $products = $paginationService->paginate($products, ["page" => $request->page]);
            return [
                "data" => $products->get(),
                "options" => $paginationService->getOptions()
            ];
        }

        return Product::get();
    }

    public function store(CreateProductRequest $request){

        $data = $request->except(['category', 'tag', 'photos']);

        $product = Product::create($data);
        $product->generateReference();

        $this->productAction($product, $request);

        return response(["status" => "success"]);
   }

   private function productAction($product, $request){

        if ($request->category && count($request->category) > 0) $product->categories()->sync($request->category);

        if ($request->tag && count($request->category) > 0) $product->tags()->sync($request->tag);

        if ($request->photos) {
            $upload = new UploadService;

            foreach ($request->photos as $key => $photo) {
                # upload all photo one by one
                $photoName = $upload->uploadFile($photo, 'product');
                $product->photos()->create(['photo' => $photoName]);
            }
        }
   }

   public function edit($id){

        $product =  Product::with(['tags', 'categories', 'photos'])->where("products.id", $id)->get();

        if(isset($product[0])) return $product[0];
        return [];
   }

   public function update(UpdateProductRequest $request){

        $data = $request->except(['category', 'tag', 'photos', 'photos_updated', 'id', 'price', 'tva', 'stock']);

        $product = Product::find($request->id);
        $product->update($data);

        // Set principal photo if it existes
        $product->setPrincipalPhoto($request->photos_updated);

        // delete not selected photo
        $photos_remove = $product->photoToDelete($request->photos_updated);

        if($photos_remove->isNotEmpty()) {
            $uploadService = new UploadService;
            foreach ($photos_remove as $key => $remove) {
                # code...
                 $uploadService->deleteFile($remove->photo, 'uploads/product');
                 $remove->delete();
            }
        }

        $this->productAction($product, $request);

        return response(["status" => "success"]);
   }

   public function updatePrice(CreatePriceRequest $request, Product $product){
        $product->update($request->all());
        return response(["status" => "success"]);
   }

    public function updateStock(CreateStockRequest $request, Product $product)
    {
        $product->update($request->all());
        return response(["status" => "success"]);
    }
}
