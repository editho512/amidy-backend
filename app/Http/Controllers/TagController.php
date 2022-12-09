<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\CreateTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function index($type)
    {
        return Tag::whereType($type)->get();
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
