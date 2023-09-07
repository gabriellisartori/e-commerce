<?php

namespace App\Services\Establishment;

use App\Models\DailyPizzaSaleLimit;
use App\Models\Establishment;

class CreateDailyPizzaSaleLimitService
{
    public function handle(array $attributes): DailyPizzaSaleLimit
    {
        $dailyPizzaSaleLimit = new DailyPizzaSaleLimit($attributes);
        $establishment = Establishment::first();
        $dailyPizzaSaleLimit->establishment_id = $establishment->id;

        $dailyPizzaSaleLimit->save();

        return $dailyPizzaSaleLimit;
    }
}