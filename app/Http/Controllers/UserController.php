<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Services\PaginationService;
use App\Services\SortService;
use App\Services\UploadService;
use App\Services\UserService;

class UserController extends Controller
{

    public function index(Request $request, PaginationService $paginationService, SortService $sortService){

        $users = User::query();

        // search the user
        $users->when($request->search && $request->search != "", function($query) use ($request){
            return $query->where('name', 'like', '%'.$request->search.'%')->orWhere('firstname', 'like', '%' . $request->search . '%');
        });

        // sort the user if sortBy attribute exist
        $users->when($request->sortBy, function($query) use($request, $sortService){
            $sorts = json_decode($request->sortBy);
            return $sortService->sort($query, $sorts);
        });

        // paginate the user
        if($request->page) {
            $users = $paginationService->paginate($users, ["page" => $request->page]);
            return [
                "data" => $users->get(),
                "options" => $paginationService->getOptions()
            ];
        }

        return $users->get();

    }

    public function store(UserCreateRequest $request, UserService $userService, UploadService $uploadService){

        $user = $userService->createUser($request->except('photo'));

        if($request->photo){

            $file = $request->photo;

            $newPhotoName = $uploadService->uploadFile($file, 'user');

            $userService->updatePhoto($user, $newPhotoName);
        }

        return response(["status" => "success"]);
    }

    public function update(UserUpdateRequest $request, User $user, UserService $userService, UploadService $uploadService){

        $user = $userService->updateUser($user, $request->except('photo'));

        if ($request->photo) {

            $file = $request->photo;

            $newPhotoName = $uploadService->uploadFile($file, 'user');

            if($user->photo != null && $user->photo != '') $uploadService->deleteFile($user->photo, 'uploads/user');

            $userService->updatePhoto($user, $newPhotoName);
        }

        return response(["status" => "success"]);
    }

    public function delete(User $user, UploadService $uploadService){

        if ($user->photo != null && $user->photo != '') $uploadService->deleteFile($user->photo, 'uploads/user');
        $user->delete();

        return response(["status" => "success"]);
    }

    public function edit(User $user){
        return $user;
    }

    public function getUserType(){
        return User::TYPE;
    }
}
