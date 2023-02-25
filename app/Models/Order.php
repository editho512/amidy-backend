<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    public $fillable = ["reference", "user_id", "status"];

    public $appends = ["date", "status_full"];

    CONST STATUS = ['Initial', 'In payment', "Paid", "Delivered"];

    public function getDateAttribute(){
        return date("d-m-Y", strtotime($this->created_at));
    }

    public function getStatusFullAttribute(){
        return self::STATUS[$this->status];
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')->withPivot("quantity", "price", "tva");

    }

    public function generateReference()
    {
        $id = generateFourNumberMin($this->id);
        $this->reference = 'ORD' . $id;
        $this->update();
    }

    public function payments(){
        return $this->hasMany(Payment::class, "order_id", "id");
    }

    public function total_amount(){
        $products = $this->products()->get();
        $totals = array_reduce($products->toArray(), function($total, $product){

            $taxe_amount = (floatval($product['pivot']['price']) * floatval($product['pivot']['tva'])) / 100;
            $total += ( floatval($product['pivot']['price']) + $taxe_amount )* floatval($product['pivot']['quantity']);

            return $total;
        });
        return $totals;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}
