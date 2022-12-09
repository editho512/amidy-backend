<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index($type)
    {
        return Category::whereType($type)->get();
    }

    public function store(CreateCategoryRequest $request)
    {
        Category::create($request->all());
        return response(["status" => "success"]);
    }

    public function edit(Category $category)
    {
        return $category;
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->except("id"));
        return response(["status" => "success"]);
    }

    public function getType()
    {
        return Category::TYPE;
    }

    public function delete(Category $category)
    {
        $category->delete();
        return response(["status" => "success"]);
    }
}
