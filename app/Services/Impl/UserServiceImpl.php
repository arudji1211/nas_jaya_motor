<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\UserService;

class UserServiceImpl implements UserService
{
    function login(string $username, $password) {}

    function register(string $email, $name, $password, $role = 'user'): User
    {
        $user = new User([
            'email' => $email,
            'name' => $name,
            'password' => md5($password),
            'role' => $role
        ]);
        $user->save();
        return $user;
    }

    function getUser(int $id): User
    {
        $user = User::query()->find($id);
        return $user;
    }
}
