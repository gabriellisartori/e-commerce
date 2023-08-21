<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Promotion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'starts_at',
        'end_at',
    ];

    public function establishment(): HasOne
    {
        return $this->hasOne(Establishment::class);
    }

    public function productPromotion(): HasOne
    {
        return $this->hasOne(ProductPromotion::class);
    }
}
