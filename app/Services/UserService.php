<?php

namespace App\Services;

use App\Models\User;

interface UserService
{
    function login(string $username, $password);
    function register(string $email, $name, $password, $role): User;
    function getUser(int $id): User;
}
