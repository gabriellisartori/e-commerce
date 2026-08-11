<?php

namespace App\Services\Ingredient;

use App\Models\Establishment;
use App\Models\Ingredient;

class CreateIngredientService
{
    public function handle(array $attributes): Ingredient
    {
        $ingredient = new Ingredient($attributes);
        $establishment = Establishment::first();
        $ingredient->establishment_id = $establishment->id;

        $ingredient->save();

        return $ingredient;
    }
}