<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessHour\CreateBusinessHourRequest;
use App\Http\Requests\BusinessHour\UpdateBusinessHourRequest;
use App\Http\Resources\BusinessHourResource;
use App\Models\BusinessHour;
use App\Services\BusinessHour\CreateBusinessHourService;
use App\Services\BusinessHour\UpdateBusinessHourService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BusinessHourController extends Controller
{
    public function __construct(
        private CreateBusinessHourService $createBusinessHourService,
        private UpdateBusinessHourService $updateBusinessHourService
    ) {
    }

    public function index()
    {
        try {
            $businessHour = BusinessHour::all();

            return response()->json(new BusinessHourResource($businessHour), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar horários de funcionamento',
            ], 401);
        }
    }

    public function store(CreateBusinessHourRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            BusinessHour::all()->each->delete();

            foreach ($data['days'] as $dayWeek) {
                $attributes = [
                    "day_week" => $dayWeek['day_week'],
                    "starts_at" => Carbon::parse($dayWeek['hours'][0]['starts_at'])->format('H:i'),
                    "end_at" => Carbon::parse($dayWeek['hours'][0]['end_at'])->format('H:i'),
                ];

                $businessHour[] = $this->createBusinessHourService->handle($attributes);
            }

            DB::commit();
            return response()->json(BusinessHourResource::collection($businessHour), 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao criar horário de funcionamento',
            ], 401);
        }
    }

    public function update(UpdateBusinessHourRequest $request)
    {
        DB::beginTransaction();
        try {
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

            DB::commit();
            return response()->json(BusinessHourResource::collection(BusinessHour::all()), 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar horário de funcionamento',
            ], 401);
        }
    }
}
