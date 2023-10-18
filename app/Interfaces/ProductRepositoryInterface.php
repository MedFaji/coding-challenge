<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{

    public function getAllProducts();
    public function getProductById($productId);
    public function createProduct(array $productDetails, array $categoryIds);
    public function updateProduct($productId, array $newDetails, array $newCategoryIds);
    public function deleteProduct($productId);
    public function searchProducts($query, $sortBy, $perPage);

}
