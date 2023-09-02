<?php

namespace App\Services\Establishment;

use App\Models\Address;
use App\Models\Establishment;

class CreateEstablishmentService
{
    public function handle(array $attributes, Address $address): Establishment
    {
        $establishment = new Establishment($attributes);
        $establishment->address_id = $address->id;

        $establishment->save();

        return $establishment;
    }
}