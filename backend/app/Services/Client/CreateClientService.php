<?php

namespace App\Services\Client;

use App\Models\Client;
use App\Models\User;

class CreateClientService
{
    public function handle(array $attributes, User $user): Client
    {
        $client = new Client($attributes);
        $client->user_id = $user->id;

        $client->save();

        return $client;
    }
}