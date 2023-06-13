<?php

use App\Domain\Auth\Models\Role;
use Illuminate\Database\Migrations\Migration;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::create(['name' => Role::$ROLE_CLIENT]);
        Role::create(['name' => Role::$ROLE_ADMIN]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::whereIn('name', [Role::$ROLE_ADMIN, Role::$ROLE_CLIENT])->delete();
    }
};
