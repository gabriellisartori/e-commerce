<?php

namespace App\Services\ProductPromotion;

use App\Models\ProductPromotion;

class CreateProductPromotionService
{
    public function handle(array $attributes): ProductPromotion
    {
        $productPromotion = ProductPromotion::create([
            'product_id' => $attributes['product_id'],
            'promotion_id' => $attributes['promotion_id'],
            'promotion_value' => $attributes['promotion_value'],
        ]);

        return $productPromotion;
    }
}