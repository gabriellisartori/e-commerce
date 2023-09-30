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
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DailyPizzaSaleLimitController extends Controller
{
    public function __construct(
        private CreateDailyPizzaSaleLimitService $createDailyPizzaSaleLimitService,
        private UpdateDailyPizzaSaleLimitService $updateDailyPizzaSaleLimitService
    ) {
    }

    public function index()
    {
        try {
            //get all daily limit
            $dailyPizzaSaleLimit = DailyPizzaSaleLimit::all();
            
            return response()->json(DailyPizzaSaleLimitResource::collection($dailyPizzaSaleLimit), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar limites diários',
            ], 401);
        }
    }

    public function show($id)
    {
        try {
            //get one daily limit
            $dailyPizzaSaleLimit = DailyPizzaSaleLimit::findOrFail($id);
            
            return response()->json(new DailyPizzaSaleLimitResource($dailyPizzaSaleLimit), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar limite diário',
            ], 401);
        }
    }

    public function store(CreateDailyPizzaSaleLimitRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            
            $dailyPizzaSaleLimit = $this->createDailyPizzaSaleLimitService->handle($data);

            DB::commit();
            return response()->json(new DailyPizzaSaleLimitResource($dailyPizzaSaleLimit), 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao criar limite diário',
            ], 401);
        }
    }

    public function update(UpdateDailyPizzaSaleLimitRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            
            $dailyPizzaSaleLimit = $this->updateDailyPizzaSaleLimitService->handle($data);
            
            DB::commit();
            return response()->json(new DailyPizzaSaleLimitResource($dailyPizzaSaleLimit), 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar limite diário',
            ], 401);
        }
    }

    public function destroy(DailyPizzaSaleLimitRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            
            DailyPizzaSaleLimit::find($data['id'])->delete();
            
            DB::commit();
            return response()->json([], 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao deletar limite diário',
            ], 401);
        }
    }
}
