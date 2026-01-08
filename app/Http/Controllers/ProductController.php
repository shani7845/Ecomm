<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;


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


public function search(Request $request)
{
    // Base query
    $query = Product::query()
        ->where('status', 1)
        ->with('category:id,name,slug');

    // 🔍 Keyword search
    if ($request->filled('q')) {
        $query->where('name', 'like', '%' . $request->q . '%');
    }

    // 📂 Category filter
    if ($request->filled('category')) {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    // 💰 Price filter
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    // Final result
    $products = $query
        ->select('id','name','slug','price','image','category_id')
        ->paginate(12)
        ->withQueryString();

    // Categories for filter dropdown   

        $categories = Category::select('id','name','slug')
    ->get();


    return view('products.search', compact('products', 'categories'));
}


}