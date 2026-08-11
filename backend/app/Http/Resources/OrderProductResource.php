<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->half_pizza) {
            $halfPizzaProduct = $this->product->where('id', $this->half_pizza_product_id)->first();
        }
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'value' => $this->value,
            'half_pizza' => $this->half_pizza,
            'half_pizza_product' => $this->when($this->half_pizza, fn () => new ProductResource($halfPizzaProduct)),
            'product' => new ProductResource($this->product),
            'additional' => $this->whenLoaded('orderProductAdditional', fn () => OrderProductAdditionalResource::collection($this->orderProductAdditional)),
        ];
    }
}
