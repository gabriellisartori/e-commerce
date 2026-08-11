<?php

namespace App\Http\Resources;

use App\Models\ProductAdditional;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductAdditionalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $productAdditional = ProductAdditional::where('id', $this->product_additional_id)->first();
        return [
            'id' => $this->id,
            'additional_value' => $this->additional_value,
            'product_additional' => new ProductAdditionalResource($productAdditional),
        ];
    }
}
