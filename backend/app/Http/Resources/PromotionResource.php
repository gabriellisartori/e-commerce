<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => $this->start_date,
            'start_time' => Carbon::parse($this->start_time)->format('H:i'),
            'end_date' => $this->end_date,
            'end_time' => Carbon::parse($this->end_time)->format('H:i'),
        ];
    }
}
