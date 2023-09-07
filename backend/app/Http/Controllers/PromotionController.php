<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Promotion\CreatePromotionRequest;
use App\Http\Requests\Promotion\PromotionRequest;
use App\Http\Requests\Promotion\UpdatePromotionRequest;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use App\Services\Promotion\CreatePromotionService;
use App\Services\Promotion\UpdatePromotionService;

class PromotionController extends Controller
{
    public function __construct(
        private CreatePromotionService $createPromotionService,
        private UpdatePromotionService $updatePromotionService
    ) {
    }

    public function index()
    {
        //get all promotion
        $promotions = Promotion::all();

        return response()->json(PromotionResource::collection($promotions));
    }

    public function show(PromotionRequest $request)
    {
        //get one promotion
        $data = $request->validated();

        $promotion = Promotion::findOrFail($data['id']);

        return response()->json(new PromotionResource($promotion));
    }

    public function store(CreatePromotionRequest $request)
    {
        $data = $request->validated();

        $promotion = $this->createPromotionService->handle($data);

        return response()->json(new PromotionResource($promotion));
    }

    public function update(UpdatePromotionRequest $request)
    {
        $data = $request->validated();

        $promotion = $this->updatePromotionService->handle($data);

        return response()->json(new PromotionResource($promotion));
    }

    public function destroy(PromotionRequest $request)
    {
        $data = $request->validated();

        Promotion::find($data['id'])->delete();

        return response()->json([], 200);
    }
}
