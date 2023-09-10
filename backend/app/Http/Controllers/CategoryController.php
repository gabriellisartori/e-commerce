<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\Category\CreateCategoryService;
use App\Services\Category\UpdateCategoryService;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function __construct(
        private CreateCategoryService $createCategoryService,
        private UpdateCategoryService $updateCategoryService
    ) {
    }

    public function index()
    {
        try {
            //get all category
            $categories = Category::all();
            
            return response()->json(CategoryResource::collection($categories), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar categorias',
            ], 401);
        }
    }

    public function show(CategoryRequest $request)
    {
        try {
            //get one category
            $data = $request->validated();
            
            $category = Category::findOrFail($data['id']);
            
            return response()->json(new CategoryResource($category), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar categoria',
            ], 401);
        }
    }

    public function store(CreateCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            
            $category = $this->createCategoryService->handle($data);
            
            return response()->json(new CategoryResource($category), 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao criar categoria',
            ], 401);
        }
    }

    public function update(UpdateCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            
            $category = $this->updateCategoryService->handle($data);
            
            return response()->json(new CategoryResource($category), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao atualizar categoria',
            ], 401);
        }
    }

    public function destroy(CategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $product = Product::where('category_id', $data['id'])->first();
            if ($product) {
                return response()->json(['message' => 'Não é possível excluir uma categoria que possui produtos.'], 400);
            }
            
            $category = Category::find($data['id']);
            
            $category->update([
                'active' => false
            ]);
            
            return response()->json(new CategoryResource($category), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao excluir categoria',
            ], 401);
        }
    }
}
