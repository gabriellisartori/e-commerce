<?php

namespace App\Services\Additional;

use App\Models\Additional;
use App\Models\Ingredient;

class CreateAdditionalService
{
    public function handle(array $attributes, Ingredient $ingredient): Additional
    {
        $additional = new Additional($attributes);
        $additional->ingredient_id = $ingredient->id;

        $additional->save();

        return $additional;
    }
}