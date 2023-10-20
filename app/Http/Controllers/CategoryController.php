<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use \Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json($this->categoryRepository->getAllCategories());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $categoryDetails = $request->validated();
        $newCategory = $this->categoryRepository->createCategory($categoryDetails);

        return response()->json($newCategory, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        $categoryId = $request->route('categoryId');
        return response()->json($this->categoryRepository->getCategoryById($categoryId));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request): JsonResponse
    {
        $categoryId = $request->route('categoryId');

        $newDetails = $request->validated();
        $updatedCategory = $this->categoryRepository->updateCategory($categoryId, $newDetails);

        return response()->json($updatedCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): JsonResponse
    {
        $categoryId = $request->route('categoryId');
        $this->categoryRepository->deleteCategory($categoryId);
        return response()->json(["message" => "Category deleted successfully"]);
    }
}
