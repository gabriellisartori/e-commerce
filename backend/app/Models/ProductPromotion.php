<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductPromotion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'promotion_value',
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }

    public function promotion(): HasOne
    {
        return $this->hasOne(Promotion::class);
    }
}
