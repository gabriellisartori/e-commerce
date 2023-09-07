<?php

namespace App\Services\Category;

use App\Models\Category;

class UpdateCategoryService
{
    public function handle(array $attributes): Category
    {
        $category = Category::findOrFail($attributes['id']);

        $category->update([
            'name' => $attributes['name'],
            'active' => $attributes['active'],
        ]);

        return $category;
    }
}