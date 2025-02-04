<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ingredient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function establishment(): HasOne
    {
        return $this->hasOne(Establishment::class);
    }

    public function additional(): HasOne
    {
        return $this->hasOne(Additional::class);
    }

    public function productIngredient(): HasOne
    {
        return $this->hasOne(productIngredient::class);
    }
}
