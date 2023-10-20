<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Interfaces\ProductRepositoryInterface;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;


class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;
    private ImageUploadService $imageUploadService;

    public function __construct(ProductRepositoryInterface $productRepository, ImageUploadService $imageUploadService)
    {
        $this->productRepository = $productRepository;
        $this->imageUploadService = $imageUploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = $request->input('s');
        $sortBy = $request->input('sort_by');
        $per_page = 3;

        $products = $this->productRepository->searchProducts($query, $sortBy, $per_page);

        return response()->json($products);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        $productId = $request->route('productId');
        $product = $this->productRepository->getProductById($productId);

        return response()->json($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $productDetails = $request->validated();
        $categoryIds = $request->input('category_ids');
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $this->imageUploadService->upload($request->file('image'));
        }

        $productDetails['image'] = $imagePath;
        $product = $this->productRepository->createProduct($productDetails, $categoryIds);

        return response()->json($product, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request): JsonResponse
    {
        $productId = $request->route('productId');
        
        $newDetails = $request->except('category_ids');
        $newCategoryIds = $request->input('category_ids');

        $product = $this->productRepository->updateProduct($productId, $newDetails, $newCategoryIds);

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): JsonResponse
    {
        $productId = $request->route('productId');

        $this->productRepository->deleteProduct($productId);
        return response()->json(["message" => "Product deleted successfully"]);
    }
}
