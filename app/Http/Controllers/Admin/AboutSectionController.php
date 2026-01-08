<?php

// app/Http/Controllers/Admin/AboutSectionController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutSectionController extends Controller
{
    public function edit()
    {
        $about = AboutSection::first();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $about = AboutSection::first() ?? new AboutSection();

        $request->validate([
            'small_title' => 'nullable|string',
            'title'       => 'nullable|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $about->small_title = $request->small_title;
        $about->title       = $request->title;
        $about->description = $request->description;

        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $about->image = $request->file('image')->store('about', 'public');
        }

        $about->is_active = true;
        $about->save();

        return back()->with('success', 'About section updated');
    }
}
