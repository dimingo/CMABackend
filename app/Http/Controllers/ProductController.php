<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(15);
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No Products Found'],404);
        }
        return new ProductCollection($products);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProduct $request)
    {
        $request = $request->validated();

        $product = Product::firstOrCreate(
            [
                'name' => $request['name'],
                'description' => $request['description'],
                'price' => $request['price']
            ]
        );
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->fill($request->only($product->getFillable()));
        $product->update();
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return new ProductResource($product);
    }
}
