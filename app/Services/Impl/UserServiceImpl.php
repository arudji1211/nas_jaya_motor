<?php

namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImpl implements UserService
{
    function login(string $username, $password): bool
    {
        return false;
    }

    function registed(string $username, $password, $role): bool
    {
        return false;
    }
}
