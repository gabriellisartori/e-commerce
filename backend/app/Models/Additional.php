<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Additional extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value',
    ];

    public function ingredient(): HasOne
    {
        return $this->hasOne(Ingredient::class);
    }

    public function productAdditional(): HasOne
    {
        return $this->hasOne(ProductAdditional::class);
    }
}
