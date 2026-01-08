<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    public function edit()
    {
        $hero = HeroSection::first();
        return view('admin.hero.edit', compact('hero'));
    }

    public function update(Request $request)
    {
        $hero = HeroSection::first() ?? new HeroSection();

        $request->validate([
            'sub_title'  => 'nullable|string',
            'title'      => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $hero->sub_title = $request->sub_title;
        $hero->title     = $request->title;

        // 🔹 Hero Image Upload
       if ($request->hasFile('hero_image')) {

    if ($hero->hero_image && Storage::disk('public')->exists($hero->hero_image)) {
        Storage::disk('public')->delete($hero->hero_image);
    }

    $hero->hero_image = $request->file('hero_image')->store('hero', 'public');
}


        $hero->is_active = true;
        $hero->save();

        return back()->with('success', 'Hero section updated successfully');
    }
}
