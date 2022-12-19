<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\UploadService;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(){
        return Product::all();
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

        $data = $request->except(['category', 'tag', 'photos', 'photos_updated', 'id']);

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
}
