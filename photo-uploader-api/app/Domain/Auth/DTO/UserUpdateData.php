<?php

namespace App\Domain\Auth\DTO;

class UserUpdateData extends BaseUserData
{
    public ?string $first_name;
    public ?string $last_name;
    public ?string $email;
    public ?string $password;
}
