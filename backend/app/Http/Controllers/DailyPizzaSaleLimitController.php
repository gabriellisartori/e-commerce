<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DailyPizzaSaleLimit\CreateDailyPizzaSaleLimitRequest;
use App\Http\Requests\DailyPizzaSaleLimit\DailyPizzaSaleLimitRequest;
use App\Http\Requests\DailyPizzaSaleLimit\UpdateDailyPizzaSaleLimitRequest;
use App\Http\Resources\DailyPizzaSaleLimitResource;
use App\Models\DailyPizzaSaleLimit;
use App\Services\DailyPizzaSaleLimit\CreateDailyPizzaSaleLimitService;
use App\Services\DailyPizzaSaleLimit\UpdateDailyPizzaSaleLimitService;

class DailyPizzaSaleLimitController extends Controller
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

        return response()->json(DailyPizzaSaleLimitResource::collection($dailyPizzaSaleLimit));
    }

    public function show($id)
    {
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

    public function destroy(DailyPizzaSaleLimitRequest $request)
    {
        $data = $request->validated();

        DailyPizzaSaleLimit::find($data['id'])->delete();

        return response()->json([], 200);
    }
}
