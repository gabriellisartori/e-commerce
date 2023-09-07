<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Category\CreateCategoryService;
use App\Services\Category\UpdateCategoryService;

class CategoryController extends Controller
{
    public function __construct(
        private CreateCategoryService $createCategoryService,
        private UpdateCategoryService $updateCategoryService
    ) {
    }

    public function index()
    {
        //get all daily pizza sale limit
        $categories = Category::all();

        return response()->json(CategoryResource::collection($categories));
    }

    public function show(CategoryRequest $request)
    {
        //get one daily pizza sale limit
        $data = $request->validated();

        $category = Category::findOrFail($data['id']);

        return response()->json(new CategoryResource($category));
    }

    public function store(CreateCategoryRequest $request)
    {
        $data = $request->validated();

        $category = $this->createCategoryService->handle($data);

        return response()->json(new CategoryResource($category));
    }

    public function update(UpdateCategoryRequest $request)
    {
        $data = $request->validated();

        $category = $this->updateCategoryService->handle($data);

        return response()->json(new CategoryResource($category));
    }

    public function destroy(CategoryRequest $request)
    {
        $data = $request->validated();
        $category = Category::find($data['id']);

        $category->update([
            'active' => false
        ]);
        
        return response()->json(new CategoryResource($category));
    }
}
