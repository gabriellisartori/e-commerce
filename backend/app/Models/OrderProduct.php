<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'value',
        'half_pizza',
        'product_id',
        'half_pizza_product_id',
        'half_pizza'
    ];

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderProductAdditional(): HasOne
    {
        return $this->hasOne(OrderProductAdditional::class);
    }
}
