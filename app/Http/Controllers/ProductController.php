<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('s');
        $sortBy = $request->input('sort_by');

        $productsQuery = Product::with('categories');

        // Apply search criteria if a query is provided.
        if ($query) {
            $productsQuery->where('name', 'LIKE', '%' . $query . '%');
        }

        // Apply sorting criteria if a sorting option is provided.
        if ($sortBy === 'name') {
            $productsQuery->orderBy('name', 'asc');
        } elseif ($sortBy === 'price') {
            $productsQuery->orderBy('price', 'asc');
        }

        $products = $productsQuery->paginate(3); // Adjust the per-page limit as needed

        return $products;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_ids' => 'required|array',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = null;
        }

        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $imagePath, // Save the image path in the database
            'category_ids' => $request->input('category_ids'),
        ]);

        $product->categories()->sync($request->input('category_ids'));
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('categories'); //eager loading
        return $product;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_ids' => 'required|array',
        ]);

        $product->update($request->all());
        $product->categories()->sync($request->input('category_ids'));

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(["message" => "Product deleted successfully"]);
    }
}
