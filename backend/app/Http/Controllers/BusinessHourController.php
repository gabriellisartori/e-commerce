<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessHour\CreateBusinessHourRequest;
use App\Http\Requests\BusinessHour\UpdateBusinessHourRequest;
use App\Http\Resources\BusinessHourResource;
use App\Models\BusinessHour;
use App\Services\BusinessHour\CreateBusinessHourService;
use App\Services\BusinessHour\UpdateBusinessHourService;

class BusinessHourController extends Controller
{
    public function __construct(
        private CreateBusinessHourService $createBusinessHourService,
        private UpdateBusinessHourService $updateBusinessHourService
    ) {
    }

    public function index()
    {
        $businessHour = BusinessHour::all();

        return response()->json(BusinessHourResource::collection($businessHour));
    }

    public function store(CreateBusinessHourRequest $request)
    {
        $data = $request->validated();

        foreach ($data['days'] as $dayWeek) {
            $attributes = [
                "day_week" => BusinessHour::WEEK_DAY[$dayWeek['day_week']],
                "starts_at" => $dayWeek['starts_at'],
                "end_at" => $dayWeek['end_at'],
            ];

            $businessHour[] = $this->createBusinessHourService->handle($attributes);
        }

        return response()->json(BusinessHourResource::collection($businessHour));
    }

    public function update(UpdateBusinessHourRequest $request)
    {
        $data = $request->validated();

        foreach ($data['days'] as $dayWeek) {
            $attributes = [
                "id" => $dayWeek['id'],
                "day_week" => BusinessHour::WEEK_DAY[$dayWeek['day_week']],
                "starts_at" => $dayWeek['starts_at'],
                "end_at" => $dayWeek['end_at'],
            ];

            $businessHour[] = $this->updateBusinessHourService->handle($attributes);
        }

        // Get IDs to delete
        $currentBusinessHours = BusinessHour::all()->toArray();
        $currentBusinessHoursIds = array_column($currentBusinessHours, 'id');
        $updateBusinessHoursIds = array_column($businessHour, 'id');
        $deleteBusinessHoursIds = array_diff($currentBusinessHoursIds, $updateBusinessHoursIds);

        if (count($deleteBusinessHoursIds)) {
            foreach ($deleteBusinessHoursIds as $deleteBusinessHour) {
                BusinessHour::find($deleteBusinessHour)->delete();
            }
        }

        return response()->json(BusinessHourResource::collection(BusinessHour::all()));
    }
}
