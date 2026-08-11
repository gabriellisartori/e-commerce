<?php

namespace App\Http\Controllers;

use App\Exports\IngredientExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ingredient\CreateIngredientRequest;
use App\Http\Requests\Ingredient\UpdateIngredientRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Additional;
use App\Models\Ingredient;
use App\Models\ProductIngredient;
use App\Services\Additional\CreateAdditionalService;
use App\Services\Additional\UpdateAdditionalService;
use App\Services\Ingredient\CreateIngredientService;
use App\Services\Ingredient\UpdateIngredientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class IngredientController extends Controller
{
    public function __construct(
        private CreateIngredientService $createIngredientService,
        private CreateAdditionalService $createAdditionalService,
        private UpdateIngredientService $updateIngredientService,
        private UpdateAdditionalService $updateAdditionalService,
    ) {
    }

    public function index(Request $request)
    {
        $inputs = $request->input();
        try {
            //get all ingredients
            $ingredients = Ingredient::query()->orderBy('name', 'asc')->with(['ingredientAdditional']);

            if (isset($inputs['name'])) {
                $ingredients->where('name', 'ilike', '%' . $inputs['name'] . '%');
            }

            $ingredients = $ingredients->get();

            return response()->json(IngredientResource::collection($ingredients), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar ingredientes',
            ], 401);
        }
    }

    public function show($id)
    {
        try {
            //get one ingredient
            $ingredient = Ingredient::findOrFail($id);

            $ingredient->load(['ingredientAdditional']);

            return response()->json(new IngredientResource($ingredient), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar ingrediente',
            ], 401);
        }
    }

    public function store(CreateIngredientRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $ingredient = $this->createIngredientService->handle($data);

            if ($data['hasAdditional']) {
                // create additional
                $this->createAdditionalService->handle($data, $ingredient);

                $ingredient->load(['ingredientAdditional']);
            }

            DB::commit();
            return response()->json(new IngredientResource($ingredient), 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao criar ingrediente',
            ], 401);
        }
    }

    public function update(UpdateIngredientRequest $request)
    {
        DB::beginTransaction();
        try {
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

            DB::commit();
            return response()->json(new IngredientResource($ingredient), 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar ingrediente',
            ], 401);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = ProductIngredient::where('ingredient_id', $id)->first();

            if ($product) {
                return response()->json(['message' => 'O ingrediente está em uso.'], 400);
            }

            Additional::where('ingredient_id', $id)->delete();

            Ingredient::find($id)->delete();

            DB::commit();
            return response()->json([], 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao deletar ingrediente',
            ], 401);
        }
    }

    public function exportFile (Request $request) 
    {
        $ingredients = $this->index($request);

        $ingredientsFile = [];

        foreach($ingredients->original->resource as $item) {
            array_push($ingredientsFile,
                [
                    'name' => $item->name,
                    'hasAdditional' => $item->ingredientAdditional !== null ? 'Sim' : 'Não',
                    'value' => $item->ingredientAdditional !== null ? $item->ingredientAdditional->value : '',
                ]
            );
        }

        $data = new IngredientExport(collect($ingredientsFile));

        return Excel::download($data, 'ingredients.csv');
    }

}
