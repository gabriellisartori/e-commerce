<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ingredient\CreateIngredientRequest;
use App\Http\Requests\Ingredient\IngredientRequest;
use App\Http\Requests\Ingredient\UpdateIngredientRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Additional;
use App\Models\Ingredient;
use App\Models\ProductIngredients;
use App\Services\Additional\CreateAdditionalService;
use App\Services\Additional\UpdateAdditionalService;
use App\Services\Ingredient\CreateIngredientService;
use App\Services\Ingredient\UpdateIngredientService;

class IngredientController extends Controller
{
    public function __construct(
        private CreateIngredientService $createIngredientService,
        private CreateAdditionalService $createAdditionalService,
        private UpdateIngredientService $updateIngredientService,
        private UpdateAdditionalService $updateAdditionalService,
    ) {
    }

    public function index()
    {
        //get all promotion
        $ingredients = Ingredient::all();

        $ingredients->load(['ingredientAdditional']);

        return response()->json(IngredientResource::collection($ingredients));
    }

    public function show(IngredientRequest $request)
    {
        //get one promotion
        $data = $request->validated();

        $ingredient = Ingredient::findOrFail($data['id']);

        $ingredient->load(['ingredientAdditional']);

        return response()->json(new IngredientResource($ingredient));
    }

    public function store(CreateIngredientRequest $request)
    {
        $data = $request->validated();

        $ingredient = $this->createIngredientService->handle($data);

        if ($data['hasAdditional']) {
            // create additional
            $this->createAdditionalService->handle($data, $ingredient);

            $ingredient->load(['ingredientAdditional']);
        }

        return response()->json(new IngredientResource($ingredient));
    }

    public function update(UpdateIngredientRequest $request)
    {
        $data = $request->validated();

        $ingredient = $this->updateIngredientService->handle($data);

        if ($data['hasAdditional']) {
            //update additional
            $additional = $this->updateAdditionalService->handle($data);

            if ($additional === null) {
                //create additional
                $this->createAdditionalService->handle($data, $ingredient);

            }

            $ingredient->load(['ingredientAdditional']);
        }
        
        return response()->json(new IngredientResource($ingredient));
    }

    public function destroy(IngredientRequest $request)
    {
        $data = $request->validated();

        $product = ProductIngredients::where('ingredient_id', $data['id'])->first();

        if ($product) {
            return response()->json(['message' => 'O ingrediente está em uso.'], 400);
        }

        Additional::where('ingredient_id', $data['id'])->delete();

        Ingredient::find($data['id'])->delete();

        return response()->json([], 200);
    }
}
