<?php

namespace App\Services\ProductAdditional;

use App\Models\ProductAdditional;

class CreateProductAdditionalService
{
    public function handle(array $attributes): ProductAdditional
    {
        $productAdditional = ProductAdditional::create([
            'product_id' => $attributes['product_id'],
            'additional_id' => $attributes['additional_id'],
            'additional_value' => $attributes['additional_value'],
        ]);

        return $productAdditional;
    }
}