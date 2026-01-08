<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\Testimonial;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $hero = HeroSection::where('is_active', true)->first();
        $about = AboutSection::where('is_active', true)->first();
        $testimonials = Testimonial::where('is_active', true)->get();

        // ✅ ONLY categories having active products
        $menuCategories = Category::withCount([
            'products' => function ($query) {
                $query->where('status', 1);
            }
        ])
        ->having('products_count', '>', 0)
        ->get();

        // ✅ Active category (URL → default first)
        $activeCategoryId = $request->get('category')
            ?? $menuCategories->first()?->id;

        // ✅ Products of active category with pagination
        $products = Product::where('status', 1)
            ->where('category_id', $activeCategoryId)
            ->paginate(8)
            ->withQueryString();

        return view('home', compact(
            'hero',
            'about',
            'testimonials',
            'menuCategories',
            'products',
            'activeCategoryId'
        ));
    }

    // ✅ AJAX products load (tab click / pagination)
    public function ajaxProducts(Request $request)
    {
        $categoryId = $request->category_id;

        $products = Product::where('status', 1)
            ->where('category_id', $categoryId)
            ->paginate(8);

        return view('partials.products-grid', compact('products'))->render();
    }
}
