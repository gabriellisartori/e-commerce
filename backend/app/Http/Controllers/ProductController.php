<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductAdditional;
use App\Models\ProductIngredient;
use App\Models\ProductPromotion;
use App\Services\Product\CreateProductService;
use App\Services\Product\UpdateProductService;
use App\Services\ProductAdditional\CreateProductAdditionalService;
use App\Services\ProductIngredient\CreateProductIngredientService;
use App\Services\ProductPromotion\CreateProductPromotionService;
use App\Services\ProductPromotion\UpdateProductPromotionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function __construct(
        private CreateProductService $createProductService,
        private CreateProductIngredientService $createProductIngredientService,
        private CreateProductPromotionService $createProductPromotionService,
        private CreateProductAdditionalService $createProductAdditionalService,
        private UpdateProductService $updateProductService,
        private UpdateProductPromotionService $updateProductPromotionService,
    ) {
    }

    public function index()
    {
        try {
            //get all products
            $products = Product::all();
            $products->load([
                'productIngredient',
                'productIngredient.ingredient',
                'category',
                'productPromotion',
                'productPromotion.promotion',
                'productAdditional',
                'productAdditional.additional'
            ]);

            return response()->json(ProductResource::collection($products), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar produtos',
            ], 401);
        }
    }

    public function show($id)
    {
        try {
            //get one product
            $product = Product::findOrFail($id);
            $product->load([
                'productIngredient',
                'productIngredient.ingredient',
                'category',
                'productPromotion',
                'productPromotion.promotion',
                'productAdditional',
                'productAdditional.additional'
            ]);

            return response()->json(new ProductResource($product), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar produto',
            ], 401);
        }
    }

    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // save image
            $this->createDirectory('basileus');

            $imageName = $data['image']->getClientOriginalName();

            $data['image']->move(public_path("images/basileus"), $imageName);

            $data['image'] = "images/basileus/$imageName";

            //create product
            $product = $this->createProductService->handle($data);

            // create data in product ingredients table
            foreach ($data['ingredients'] as $ingredient) {
                $ingredient['product_id'] = $product->id;
                $this->createProductIngredientService->handle($ingredient);
            }

            if ($data['promotion']) {
                // create data in product_promotion table
                $data['promotion_value'] = $data['promotion'][0]['value'] ?? null;
                $data['promotion_id'] = $data['promotion'][0]['id'];
                $data['product_id'] = $product->id;
                $this->createProductPromotionService->handle($data);
            }

            if ($data['additional']) {
                // create data in product_additional table
                foreach ($data['additional'] as $additional) {
                    $additional['product_id'] = $product->id;
                    $additional['additional_id'] = $additional['id'];
                    $additional['additional_value'] = $additional['value'] ?? null;

                    $this->createProductAdditionalService->handle($additional);
                }
            }
            
            $product->load([
                'productIngredient',
                'productIngredient.ingredient',
                'category',
                'productPromotion',
                'productPromotion.promotion',
                'productAdditional',
                'productAdditional.additional'
            ]);

            DB::commit();
            return response()->json(new ProductResource($product), 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao criar produto',
            ], 401);
        }
    }

    public function update(UpdateProductRequest $request)
    {
        DB::beginTransaction();
        $data = $request->validated();
        try {
            if (!is_string($data['image'])) {
                $imageName = $data['image']->getClientOriginalName();

                $data['image']->move(public_path("images/basileus"), $imageName);

                $data['image'] = "images/basileus/$imageName";
            }

            $product = $this->updateProductService->handle($data);

            ProductIngredient::where('product_id', $product->id)->delete();
            // update ingredients
            foreach ($data['ingredients'] as $ingredient) {
                $ingredient['product_id'] = $product->id;
                $ingredient['ingredient_id'] = $ingredient['id'];
                $this->createProductIngredientService->handle($ingredient);
            }

            if ($data['promotion']) {
                // update promotion
                $data['promotion_id'] = $data['promotion'][0]['id'];
                $data['promotion_value'] = $data['promotion'][0]['value'] ?? null;
                $productPromotion = ProductPromotion::where('product_id', $product->id)->first();

                if ($productPromotion && $productPromotion->promotion_id === $data['promotion_id']) {
                    if ($productPromotion->value !== $data['promotion_value']) {
                        $this->updateProductPromotionService->handle($data);
                    }
                } else {
                    $productPromotion->delete();
                    $this->createProductPromotionService->handle($data);
                }
            } else {
                ProductPromotion::where('product_id', $product->id)->delete();
            }

            if ($data['additional']) {
                // update additional
                ProductAdditional::where('product_id', $product->id)->delete();
                foreach ($data['additional'] as $additional) {
                    $additional['product_id'] = $product->id;
                    $additional['additional_id'] = $data['id'];
                    $additional['additional_value'] = $data['value'] ?? null;

                    $this->createProductAdditionalService->handle($additional);
                }
            } else {
                ProductAdditional::where('product_id', $product->id)->delete();
            }

            $product->load([
                'productIngredient',
                'productIngredient.ingredient',
                'category',
                'productPromotion',
                'productPromotion.promotion',
                'productAdditional',
                'productAdditional.additional'
            ]);

            DB::commit();
            return response()->json(new ProductResource($product), 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar produto',
            ], 401);
        }
    }

    private function createDirectory(string $establishmentName)
    {
        $path = public_path("images/$establishmentName");

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }
}
