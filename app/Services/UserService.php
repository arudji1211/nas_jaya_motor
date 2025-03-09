<?php

namespace App\Services;

interface UserService
{
    function login(string $username, $password): bool;
    function registed(string $username, $password, $role): bool;
}
