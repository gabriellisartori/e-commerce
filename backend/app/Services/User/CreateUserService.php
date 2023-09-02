<?php

namespace App\Services\User;

use App\Models\Establishment;
use App\Models\User;

class CreateUserService
{
    public function handle(array $attributes, ?Establishment $establishment): User
    {
        $user = new User($attributes);
        $user->establishment_id = $establishment->id;

        $user->save();

        return $user;
    }
}