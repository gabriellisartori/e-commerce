<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'start_date',
        'start_time',
        'end_date',
        'end_time'
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
