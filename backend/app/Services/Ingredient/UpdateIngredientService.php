<?php

namespace App\Services\Ingredient;

use App\Models\Ingredient;

class UpdateIngredientService
{
    public function handle(array $attributes): Ingredient
    {
        $ingredient = Ingredient::findOrFail($attributes['id']);

        $ingredient->update([
            'name' => $attributes['name']
        ]);
            
        return $ingredient;
    }
}