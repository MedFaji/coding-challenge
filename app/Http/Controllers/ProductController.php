<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories')->get();
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

        $product = Product::create($request->all());
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

    public function search(Request $request)
    {
        $query = $request->input('s');
        $productsQuery = Product::with('categories')->where('name', 'LIKE', '%' . $query . '%');
        $products = $productsQuery->get(); // Adjust the per-page limit as needed

        return $products;
    }
}
