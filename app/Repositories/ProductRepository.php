<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{

    public function searchProducts($query, $sortBy, $perPage)
    {
        $productsQuery = Product::with('categories');

        if ($query) {
            $productsQuery->where('name', 'LIKE', '%' . $query . '%');
        }

        if ($sortBy === 'name') {
            $productsQuery->orderBy('name', 'asc');
        } elseif ($sortBy === 'price') {
            $productsQuery->orderBy('price', 'asc');
        }

        return $productsQuery->paginate($perPage);
    }

    public function getAllProducts()
    {
        return Product::with('categories')->paginate(3);
    }

    public function getProductById($productId)
    {
        return Product::findOrFail($productId)->load('categories');
    }

    public function createProduct(array $productDetails, array $categoryIds)
    {
        $product = Product::create($productDetails);
        $product->categories()->sync($categoryIds);
        return $product;
    }

    public function updateProduct($productId, array $newDetails, array $newCategoryIds)
    {
        $product = Product::whereId($productId)->update($newDetails);
        $product->categories()->sync($newCategoryIds);
        return $product;
    }

    public function deleteProduct($productId)
    {
        Product::destroy($productId);
    }
}
