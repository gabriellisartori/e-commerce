<?php

namespace App\Http\Controllers;

use App\Exports\PromotionExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Promotion\CreatePromotionRequest;
use App\Http\Requests\Promotion\PromotionRequest;
use App\Http\Requests\Promotion\UpdatePromotionRequest;
use App\Http\Resources\PromotionResource;
use App\Models\Product;
use App\Models\ProductPromotion;
use App\Models\Promotion;
use App\Services\Promotion\CreatePromotionService;
use App\Services\Promotion\UpdatePromotionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class PromotionController extends Controller
{
    public function __construct(
        private CreatePromotionService $createPromotionService,
        private UpdatePromotionService $updatePromotionService
    ) {
    }

    public function index(Request $request)
    {
        $inputs = $request->input();
        try {
            //get all promotion
            $promotions = Promotion::query()->orderBy('name', 'asc');

            if (isset($inputs['name'])) {
                $promotions->where('name', 'ilike', '%' . $inputs['name'] . '%');
            }

            $promotions = $promotions->get();
            
            return response()->json(PromotionResource::collection($promotions), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar promoções',
            ], 401);
        }
    }

    public function show($id)
    {
        try {
            //get one promotion
            $promotion = Promotion::findOrFail($id);
            
            return response()->json(new PromotionResource($promotion), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar promoção',
            ], 401);
        }
    }

    public function store(CreatePromotionRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            
            $promotion = $this->createPromotionService->handle($data);
            
            DB::commit();
            return response()->json(new PromotionResource($promotion), 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao criar promoção',
            ], 401);
        }
    }

    public function update(UpdatePromotionRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            
            $promotion = $this->updatePromotionService->handle($data);
            
            DB::commit();
            return response()->json(new PromotionResource($promotion), 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar promoção',
            ], 401);
        }   
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = ProductPromotion::where('promotion_id', $id)->first();
            if ($product) {
                return response()->json(['message' => 'Promoção não pode ser deletada, pois está sendo usada em um produto'], 400);
            }
            
            Promotion::find($id)->delete();
            
            DB::commit();
            return response()->json([], 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao deletar promoção',
            ], 401);
        }
    }

    public function exportFile (Request $request) 
    {
        $promotions = $this->index($request);

        $promotionsFile = [];

        foreach($promotions->original->resource as $item) {
            array_push($promotionsFile,
                [
                    'name' => $item->name,
                    'start_date' => Carbon::parse($item->start_date)->format('d/m/Y'),
                    'start_time' => $item->start_time,
                    'end_date' => Carbon::parse($item->end_date)->format('d/m/Y'),
                    'end_time' => $item->end_time,
                ]
            );
        }

        $data = new PromotionExport(collect($promotionsFile));

        return Excel::download($data, 'promotion.csv');
    }
}
