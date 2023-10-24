<?php

namespace App\Services\Promotion;

use App\Models\Promotion;

class UpdatePromotionService
{
    public function handle(array $attributes): Promotion
    {
        $promotion = Promotion::findOrFail($attributes['id']);

        $promotion->update([
            'name' => $attributes['name'],
            'start_date' => $attributes['start_date'],
            'start_time' => $attributes['start_time'],
            'end_date' => $attributes['end_date'],
            'end_time' => $attributes['end_time'],
        ]);

        return $promotion;
    }
}