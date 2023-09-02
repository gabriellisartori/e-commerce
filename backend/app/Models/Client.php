<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cpf',
        'date_birth',
        'phone_number',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
