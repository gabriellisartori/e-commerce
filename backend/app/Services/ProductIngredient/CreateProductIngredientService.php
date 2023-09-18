<?php

namespace App\Services\ProductIngredient;

use App\Models\ProductIngredient;

class CreateProductIngredientService
{
    public function handle(array $attributes): ProductIngredient
    {
        $productIngredient = ProductIngredient::create([
            'product_id' => $attributes['product_id'],
            'ingredient_id' => $attributes['id'],
        ]);

        return $productIngredient;
    }
}