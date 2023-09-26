<?php

namespace App\Services\Client;

use App\Models\Client;

class UpdateClientService
{
    public function handle(array $attributes): Client
    {
        $client = Client::findOrFail($attributes['id']);

        $client->update([
            'name' => $attributes['name'],
            'cpf' => $attributes['cpf'],
            'phone_number' => $attributes['phone_number'],
            'date_birth' => $attributes['date_birth']
        ]);

        return $client;
    }
}