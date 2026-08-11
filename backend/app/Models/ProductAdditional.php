<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'product_id',
        'additional_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function additional(): BelongsTo
    {
        return $this->belongsTo(Additional::class);
    }

    public function orderProductAdditional(): HasMany
    {
        return $this->hasMany(OrderProductAdditional::class);
    }
}
