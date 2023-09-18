<?php

namespace App\Services\ProductPromotion;

use App\Models\ProductPromotion;

class UpdateProductPromotionService
{
    public function handle(array $attributes): ProductPromotion
    {
        $productPromotion = ProductPromotion::findOrFail($attributes['id']);

        $productPromotion->update([
            'value' => $attributes['value']
        ]);
            
        return $productPromotion;
    }
}