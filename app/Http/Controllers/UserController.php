<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserCreateUserRequest;
use App\Services\UserService;

class UserController extends Controller
{

    public function index(){
        return User::all();
    }
    //
    public function store(UserCreateUserRequest $request, UserService $userService){

        $user = $userService->createUser($request->except('photo'));

        return response(["status" => "success"]);
    }

    public function getUserType(){
        return User::TYPE;
    }
}
