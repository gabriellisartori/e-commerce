<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductIngredients extends Model
{
    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }

    public function ingredient(): HasOne
    {
        return $this->hasOne(Ingredient::class);
    }
}
