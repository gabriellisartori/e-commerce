<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductAdditional extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'additional_value',
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }

    public function additional(): HasOne
    {
        return $this->hasOne(Additional::class);
    }

    public function orderProductAdditional(): HasMany
    {
        return $this->hasMany(OrderProductAdditional::class);
    }
}
