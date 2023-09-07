<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Establishment\CreateDailyPizzaSaleLimitRequest;
use App\Http\Requests\Establishment\ShowDailyPizzaSaleLimitRequest;
use App\Http\Requests\Establishment\UpdateDailyPizzaSaleLimitRequest;
use App\Http\Resources\DailyPizzaSaleLimitResource;
use App\Models\DailyPizzaSaleLimit;
use App\Services\Establishment\CreateDailyPizzaSaleLimitService;
use App\Services\Establishment\UpdateDailyPizzaSaleLimitService;

class BusinessHourController extends Controller
{
    public function __construct(
        private CreateDailyPizzaSaleLimitService $createDailyPizzaSaleLimitService,
        private UpdateDailyPizzaSaleLimitService $updateDailyPizzaSaleLimitService
    ) {
    }

    public function index()
    {
        //get all daily limit
        $dailyPizzaSaleLimit = DailyPizzaSaleLimit::all();

        return response()->json(new DailyPizzaSaleLimitResource($dailyPizzaSaleLimit));
    }

    public function show(ShowDailyPizzaSaleLimitRequest $request)
    {
        $id = $request->validated();

        //get one daily limit
        $dailyPizzaSaleLimit = DailyPizzaSaleLimit::findOrFail($id);

        return response()->json(new DailyPizzaSaleLimitResource($dailyPizzaSaleLimit));
    }

    public function store(CreateDailyPizzaSaleLimitRequest $request)
    {
        $data = $request->validated();

        $dailyPizzaSaleLimit = $this->createDailyPizzaSaleLimitService->handle($data);

        return response()->json(new DailyPizzaSaleLimitResource($dailyPizzaSaleLimit));
    }

    public function update(UpdateDailyPizzaSaleLimitRequest $request)
    {
        $data = $request->validated();

        $dailyPizzaSaleLimit = $this->updateDailyPizzaSaleLimitService->handle($data);

        return response()->json(new DailyPizzaSaleLimitResource($dailyPizzaSaleLimit));
    }

    public function destroy(ShowDailyPizzaSaleLimitRequest $request)
    {
        $id = $request->validated();

        DailyPizzaSaleLimit::find($id)->delete();

        return response()->json([], 200);
    }
}
