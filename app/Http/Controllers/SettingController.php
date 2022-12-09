<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\CreateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SettingController extends Controller
{
    //

    public function index(){
        return Setting::first();
    }

    public function store(CreateSettingRequest $request){
        Setting::truncate();
        Setting::create($request->all());

        return response(["status" => "success"]);
    }
}
