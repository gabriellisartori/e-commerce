<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EstablishmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cnpj' => $this->cnpj,
            'phone_number' => $this->phone_number,
            'description' => $this->description,
            'user_id' => $this->user->id,
            'email' => $this->user->email,
            'address' => $this->whenLoaded('address', fn () => new AddressResource($this->address)),
        ];
    }
}
