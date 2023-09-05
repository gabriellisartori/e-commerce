<?php

namespace App\Services\Establishment;

use App\Models\Establishment;

class UpdateEstablishmentService
{
    public function handle(array $attributes): Establishment
    {
        $establishment = Establishment::findOrFail($attributes['id']);

        $establishment->update([
            'name' => $attributes['name'],
            'cnpj' => $attributes['cnpj'],
            'phone_number' => $attributes['phone_number'],
            'description' => $attributes['description'] ?? null
        ]);

        return $establishment;
    }
}