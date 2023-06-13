<?php

namespace App\Domain\Auth\DTO;

use App\Domain\Auth\Models\Role;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

abstract class BaseUserData extends DataTransferObject
{
    public static function fromRequest(Request $request)
    {
        return new static($request->all());
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password ? bcrypt($this->password) : null;
    }

    public function getClientRoleId() {
        $clientRole = Role::where('name', Role::$ROLE_CLIENT)->first();
        return $clientRole ? $clientRole->id : null;
    }
}
