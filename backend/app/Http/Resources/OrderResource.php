<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'observation' => $this->observation,
            'total_value' => $this->total_value,
            'paid' => $this->paid,
            'client' => $this->whenLoaded('client', fn () => new ClientResource($this->client)),
            'products' => $this->whenLoaded('orderProduct', fn () => OrderProductResource::collection($this->orderProduct)),
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y • H:i'),
        ];
    }
}
