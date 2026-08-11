<?php

namespace App\Services\User;

use App\Models\User;

class UpdateUserService
{
    public function handle(array $attributes, User $user): User
    {
        if (isset($attributes['password'])) {
            $user->update([
                'email' => $attributes['email'],
                'password' => $attributes['password'],
            ]);
        } else {
            $user->update([
                'email' => $attributes['email']
            ]);
        }

        return $user;
    }
}