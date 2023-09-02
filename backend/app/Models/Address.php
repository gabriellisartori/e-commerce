<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'zip_code',
        'city',
        'street',
        'neighborhood',
        'number',
        'complement',
    ];

    public function establishment(): HasOne
    {
        return $this->hasOne(Establishment::class);
    }
}
