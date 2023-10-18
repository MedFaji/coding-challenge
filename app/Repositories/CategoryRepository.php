<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function getAllCategories()
    {
        return Category::with('children', 'parent')->get();
    }

    public function getCategoryById($categoryId)
    {
        return Category::findOrFail($categoryId)->load('children', 'parent');
    }

    public function createCategory(array $categoryDetails)
    {
        return Category::create($categoryDetails);

    }

    public function updateCategory($categoryId, array $newDetails)
    {
        return Category::whereId($categoryId)->update($newDetails);

    }

    public function deleteCategory($categoryId)
    {
        Category::destroy($categoryId);
    }
}
