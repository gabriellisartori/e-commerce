<?php

namespace App\Services\Promotion;

use App\Models\Establishment;
use App\Models\Promotion;

class CreatePromotionService
{
    public function handle(array $attributes): Promotion
    {
        $promotion = new Promotion($attributes);
        $establishment = Establishment::first();
        $promotion->establishment_id = $establishment->id;

        $promotion->save();

        return $promotion;
    }
}