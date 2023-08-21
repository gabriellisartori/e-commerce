<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'value',
        'active',
    ];

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }

    public function establishment(): HasOne
    {
        return $this->hasOne(Establishment::class);
    }
}
