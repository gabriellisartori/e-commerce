<?php

namespace App\Services\Product;

use App\Models\Product;

class UpdateProductService
{
    public function handle(array $attributes): Product
    {
        $product = Product::findOrFail($attributes['id']);

        $product->update([
            'name' => $attributes['name'],
            'image' => $attributes['image'],
            'value' => $attributes['value'],
            'active' => $attributes['active'],
            'category_id' => $attributes['category_id']
        ]);
            
        return $product;
    }
}