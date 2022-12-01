<?php
namespace App\Services;

use App\Models\User;
use Ramsey\Uuid\Type\Integer;

class UserService {

    public function __construct()
    {

    }

    public function createUser(array $user) : User {

        $user['password'] = $this->passwordCrypt($user['password']);

        return User::create($user);
    }

    public function updateUser(User $userOld, array $user): User
    {
        if(isset($user['password'])) $user['password'] = $this->passwordCrypt($user['password']);

        $userOld->update($user);

        return $userOld;
    }

    public function updatePhoto(User $user, string $photoName) : User {
        $user->photo = $photoName;
        $user->update();
        return $user;
    }

    public function passwordCrypt(String $password) : String {
        return bcrypt($password);
    }
}
