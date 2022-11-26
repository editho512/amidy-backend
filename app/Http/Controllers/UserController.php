<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserCreateUserRequest;
use App\Services\UploadService;
use App\Services\UserService;

class UserController extends Controller
{

    public function index(){
        return User::all();
    }
    //
    public function store(UserCreateUserRequest $request, UserService $userService, UploadService $uploadService){

        $user = $userService->createUser($request->except('photo'));

        if($request->photo){

            $file = $request->photo;

            $newPhotoName = $uploadService->uploadFile($file, 'user');

            $userService->updatePhoto($user, $newPhotoName);
        }

        return response(["status" => "success"]);
    }

    public function getUserType(){
        return User::TYPE;
    }
}
