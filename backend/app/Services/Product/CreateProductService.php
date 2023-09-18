<?php

namespace App\Services\Product;

use App\Models\Establishment;
use App\Models\Product;

class CreateProductService
{
    public function handle(array $attributes): Product
    {
        $product = new Product($attributes);
        $establishment = Establishment::first();
        $product->establishment_id = $establishment->id;
        $product->category_id = $attributes['category_id'];

        $product->save();

        return $product;
    }
}