<?php

namespace App\Http\Resources;

use App\Models\Additional;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAdditionalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $additional = Additional::find($this->additional_id)->load('ingredient');
        return [
            'id' => $this->id,
            'value' => $this->additional_value,
            'name' => $additional->ingredient->name,
        ];
    }
}
