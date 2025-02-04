<?php

namespace App\Models;

use App\Models\Establishment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BusinessHour extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'day_week',
        'starts_at',
        'end_at',
    ];

    public function establishment(): HasOne
    {
        return $this->hasOne(Establishment::class);
    }

}
