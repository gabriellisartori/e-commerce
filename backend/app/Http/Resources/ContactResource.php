<?php

namespace App\Http\Resources;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $street = $this->address->street . ', ' . $this->address->number;
        $city = $this->address->neighborhood . ', ' . $this->address->city . '/RS';
        return [
            'phone_number' => $this->phone_number,
            'email' => $this->user->email,
            'street' => $street,
            'complement' => $this->address->complement,
            'city' => $city,
            'zip_code' => $this->address->zip_code
        ];
    }
}
