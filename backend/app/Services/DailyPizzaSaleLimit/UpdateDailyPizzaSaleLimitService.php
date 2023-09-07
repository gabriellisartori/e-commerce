<?php

namespace App\Services\DailyPizzaSaleLimit;

use App\Models\DailyPizzaSaleLimit;

class UpdateDailyPizzaSaleLimitService
{
    public function handle(array $attributes): DailyPizzaSaleLimit
    {
        $dailyPizzaSaleLimit = DailyPizzaSaleLimit::findOrFail($attributes['id']);

        $dailyPizzaSaleLimit->update([
            'quantity' => $attributes['quantity'],
            'date' => $attributes['date'],
            'starts_at' => $attributes['starts_at'],
            'end_at' => $attributes['end_at']
        ]);

        return $dailyPizzaSaleLimit;
    }
}