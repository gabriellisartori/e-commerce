<?php

namespace App\Services\Additional;

use App\Models\Additional;

class UpdateAdditionalService
{
    public function handle(array $attributes): Additional|null
    {
        $additional = Additional::where('ingredient_id', $attributes['id'])->first();

        if ($additional) {
            $additional->update([
                'value' => $attributes['value']
            ]);
        }
            
        return $additional;
    }
}