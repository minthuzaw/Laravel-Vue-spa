<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;


class ProductController extends Controller
{
    public function index()
    {
//        $products = Product::query();
//        if(request('search')){
//            return $products->where('name', 'like', '%' .request('search'). '%')
//                ->orderBy('id', 'desc')->get();
//        }
//        else{
//            return $products->orderBy('id', 'desc')->paginate(10);
//        }

        return Product::when(request('search'), function($query){
            $query->where('name', 'like', '%' .request('search'). '%');
        })->orderBy('id', 'desc')->paginate(10);

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
