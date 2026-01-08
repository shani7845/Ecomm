<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        // load product with its category
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();

        // related products: same category, active, exclude current
        $relatedProducts = collect();
        if ($product->category_id) {
            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('status', 1)
                ->limit(8)
                ->get();
        }

        return view('products.show', compact('product', 'relatedProducts'));
    }
}