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
            'starts_at' => $attributes['starts_at'],
            'end_at' => $attributes['end_at']
        ]);

        return $promotion;
    }
}