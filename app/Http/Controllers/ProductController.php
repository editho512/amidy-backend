<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function store(CreateProductRequest $request){
        return response(["status" => "success"]);

   }
}
