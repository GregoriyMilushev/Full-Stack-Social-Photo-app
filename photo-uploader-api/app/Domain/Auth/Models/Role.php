<?php

namespace App\Domain\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public static string $ROLE_CLIENT = 'client';
    public static string $ROLE_ADMIN = 'admin';

    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
