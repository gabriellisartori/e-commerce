<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'observation',
        'total_value',
        'paid',
        'client_id',
        'establishment_id'
    ];

    public function establishment(): HasOne
    {
        return $this->hasOne(Establishment::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function orderProduct(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
}
