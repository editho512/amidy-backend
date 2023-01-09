<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Services\PaginationService;
use App\Http\Requests\Tag\CreateTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;

class TagController extends Controller
{

    public function index(Request $request, PaginationService $paginationService,$type)
    {
        $tags = Tag::whereType($type);

        // search the tags
        $tags->when($request->search && $request->search != "",
            function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            });

        // paginate the tags
        if ($request->page) {
            $tags = $paginationService->paginate($tags, ["page" => $request->page]);
            return [
                "data" => $tags->get(),
                "options" => $paginationService->getOptions()
            ];
        }

        return $tags->get();
    }

    public function getType(){
        return Tag::TYPE;
    }

    public function store(CreateTagRequest $request){
        $tag = Tag::create($request->all());
        return response(["status" => "success"]);
    }

    public function edit(Tag $tag){
        return $tag;
    }

    public function update(UpdateTagRequest $request, Tag $tag){
        $tag->update($request->except("id"));
        return response(["status" => "success"]);
    }

    public function delete(Tag $tag){
        $tag->delete();
        return response(["status" => "success"]);
    }

}
