<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'value',
        'active',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function establishment(): HasOne
    {
        return $this->hasOne(Establishment::class);
    }

    public function orderProduct(): HasOne
    {
        return $this->hasOne(OrderProduct::class);
    }

    public function productAdditional(): HasOne
    {
        return $this->hasOne(ProductAdditional::class);
    }

    public function productIngredient(): HasMany
    {
        return $this->hasMany(ProductIngredient::class);
    }

    public function productPromotion(): HasOne
    {
        return $this->hasOne(ProductPromotion::class);
    }
}
