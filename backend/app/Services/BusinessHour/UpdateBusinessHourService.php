<?php

namespace App\Services\BusinessHour;

use App\Models\BusinessHour;

class UpdateBusinessHourService
{
    public function handle(array $attributes): BusinessHour
    {
        $businessHour = BusinessHour::findOrFail($attributes['id']);

        $businessHour->update([
            'day_week' => $attributes['day_week'],
            'starts_at' => $attributes['starts_at'],
            'end_at' => $attributes['end_at']
        ]);

        return $businessHour;
    }
}