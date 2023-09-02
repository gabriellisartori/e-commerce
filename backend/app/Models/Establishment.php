<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Establishment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cnpj',
        'phone_number',
        'description'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function businessHour(): HasMany
    {
        return $this->hasMany(BusinessHour::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }

    public function ingredient(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function promotion(): HasOne
    {
        return $this->hasOne(Promotion::class);
    }
}
