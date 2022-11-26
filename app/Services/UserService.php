<?php
namespace App\Services;

use App\Models\User;
use Ramsey\Uuid\Type\Integer;

class UserService {

    public function __construct()
    {

    }

    public function createUser(array $user) : User {

        $user['password'] = bcrypt($user['password']);
        $user['type'] = $this->getUserTypeByValue($user['type']);

        return User::create($user);

    }

    public function getUserTypeByValue(String $userType): int {

        foreach (User::TYPE as $key => $type) {
            if($type === $userType) return $key;
        }
    }

    public function updatePhoto(User $user, string $photoName) : User {
        $user->photo = $photoName;
        $user->update();
        return $user;
    }
}
