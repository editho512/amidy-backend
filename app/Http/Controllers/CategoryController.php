<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\PaginationService;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{

    public function index(Request $request, PaginationService $paginationService,$type)
    {
        $categories = Category::whereType($type);

        //search the categories
        $categories->when(
            $request->search && $request->search != "",
            function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            }
        );

        // paginate the categories
        if ($request->page) {
            $categories = $paginationService->paginate($categories, ["page" => $request->page]);
            return [
                "data" => $categories->get(),
                "options" => $paginationService->getOptions()
            ];
        }

        return $categories->get();
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
