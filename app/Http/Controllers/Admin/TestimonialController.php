<?php

// app/Http/Controllers/Admin/TestimonialController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string',
            'message' => 'required|string',
            'image'   => 'nullable|image|max:2048',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        $data = $request->only(['name', 'message', 'rating']);
        $data['is_active'] = true;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added');
    }



    public function edit(Testimonial $testimonial)
{
    return view('admin.testimonials.edit', compact('testimonial'));
}


public function destroy(Testimonial $testimonial)
{
    if ($testimonial->image) {
        Storage::disk('public')->delete($testimonial->image);
    }

    $testimonial->delete();

    return back()->with('success', 'Testimonial deleted');
}

        public function update(Request $request, Testimonial $testimonial)
        {
            $request->validate([
                'name'    => 'required|string',
                'message' => 'required|string',
                'image'   => 'nullable|image|max:2048',
                'rating'  => 'required|integer|min:1|max:5',
            ]);

            $testimonial->name = $request->name;
            $testimonial->message = $request->message;
            $testimonial->rating = $request->rating;

            if ($request->hasFile('image')) {
                if ($testimonial->image) {
                    Storage::disk('public')->delete($testimonial->image);
                }

                $testimonial->image = $request->file('image')->store('testimonials', 'public');
            }

            $testimonial->save();

            return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated');
        }

}
