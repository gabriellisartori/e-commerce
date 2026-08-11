<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'image' => $this->image,
            'value' => $this->value,
            'active' => $this->active,
            'category' => $this->whenLoaded('category', fn () => new CategoryResource($this->category)),
            'ingredients' => $this->whenLoaded('productIngredient', fn () => ProductIngredientResource::collection($this->productIngredient)),
            'promotion' => $this->whenLoaded('productPromotion', fn () => new ProductPromotionResource($this->productPromotion)),
            'additional' => $this->whenLoaded('productAdditional', fn () => new ProductAdditionalResource($this->productAdditional)),
        ];
    }
}
