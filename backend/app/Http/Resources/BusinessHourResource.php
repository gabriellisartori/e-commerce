<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessHourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->getDayWeek();;
    }

    private function getDayWeek(): array
    {
        $businessHour = $this->resource->toArray();
        $days = [];

        foreach ($businessHour as $key => $day) {
            $values = [
                'day_week' => $day['day_week'],
                'hours' => [
                    [
                        'starts_at' => $day['starts_at'] !== null ? Carbon::parse($day['starts_at'])->format('H:i') : null,
                        'end_at' => $day['end_at'] !== null ? Carbon::parse($day['end_at'])->format('H:i') : null
                    ]
                ]
            ];

            if (count($days) === 0) {
                array_push($days, $values);
            } else {
                foreach ($days as $key => $value) {
                    if ($value['day_week'] === $day['day_week']) {
                        array_push(
                            $days[$key]['hours'],
                            [
                                'starts_at' => Carbon::parse($day['starts_at'])->format('H:i'),
                                'end_at' => Carbon::parse($day['end_at'])->format('H:i')
                            ]
                        );
                        break;
                    } else {
                        array_push($days, $values);
                        break;
                    }
                }
            }
        }
        return $days;
    }
}
