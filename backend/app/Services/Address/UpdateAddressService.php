<?php

namespace App\Services\Address;

use App\Models\Address;

class UpdateAddressService
{
    public function handle(array $attributes): Address
    {
        $address = Address::findOrFail($attributes['address_id']);

        $address->update([
            'zip_code' => $attributes['zip_code'],
            'city' => $attributes['city'],
            'street' => $attributes['street'],
            'neighborhood' => $attributes['neighborhood'],
            'number' => $attributes['number'],
            'complement' => $attributes['complement'] ?? null
        ]);

        return $address;
    }
}