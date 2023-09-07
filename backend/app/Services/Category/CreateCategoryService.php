<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Models\Establishment;

class CreateCategoryService
{
    public function handle(array $attributes): Category
    {
        $category = new Category($attributes);
        $establishment = Establishment::first();
        $category->establishment_id = $establishment->id;

        $category->save();

        return $category;
    }
}