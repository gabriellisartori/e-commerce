<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderProductAdditional extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'additional_value',
        'product_additional_id'
    ];

    public function productAdditional(): HasOne
    {
        return $this->hasOne(ProductAdditional::class);
    }

    public function orderProduct(): HasOne
    {
        return $this->hasOne(OrderProduct::class);
    }
}
