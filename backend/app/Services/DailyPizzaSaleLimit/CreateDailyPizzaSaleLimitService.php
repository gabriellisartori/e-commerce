<?php

namespace App\Services\Establishment;

use App\Models\DailyPizzaSaleLimit;

class CreateDailyPizzaSaleLimitService
{
    public function handle(array $attributes): DailyPizzaSaleLimit
    {
        $dailyPizzaSaleLimit = new DailyPizzaSaleLimit($attributes);

        $dailyPizzaSaleLimit->save();

        return $dailyPizzaSaleLimit;
    }
}