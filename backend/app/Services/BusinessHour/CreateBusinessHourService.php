<?php

namespace App\Services\BusinessHour;

use App\Models\BusinessHour;
use App\Models\Establishment;

class CreateBusinessHourService
{
    public function handle(array $attributes): BusinessHour
    {
        $establishment = Establishment::first();
        $businessHour = new BusinessHour($attributes);
        $businessHour->establishment_id = $establishment->id;

        $businessHour->save();

        return $businessHour;
    }
}