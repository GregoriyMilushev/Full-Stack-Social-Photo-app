<?php

namespace App\Domain\Auth\DTO;

class UserCreateData extends BaseUserData
{
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
}
