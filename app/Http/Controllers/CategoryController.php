<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
 public function show($slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();
    $products = $category->products()
    ->where('status',1)
    ->paginate(12);
    
    return view('category.show', compact('category','products'));
}

        
}