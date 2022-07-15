<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::orderBy('id', 'desc')->get();
    }

    public function store(ProductStoreRequest $request)
    {
        $attributes = $request->validated();
        $product = Product::create($attributes);
        return $product;
    }

    public function show(Product $product)
    {
//        $product = Product::find($id);
        return $product;
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $attributes = $request->validated();
//        $product = Product::find($id);
        $product->update($attributes);
        return $product;
    }

    public function destroy(Product $product)
    {
//        $product = Product::find($id);
        $product->delete();

    }
}
