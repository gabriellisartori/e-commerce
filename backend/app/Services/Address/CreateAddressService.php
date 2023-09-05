<?php

namespace App\Services\Address;

use App\Models\Address;

class CreateAddressService
{
    public function handle(array $attributes): Address
    {
        $address = new Address($attributes);

        $address->save();

        return $address;
    }
}