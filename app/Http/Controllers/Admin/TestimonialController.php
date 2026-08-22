<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(20);
        return view('cms.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('cms.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'role_company' => 'nullable|string|max:255',
            'message' => 'required|string',
            'is_approved' => 'boolean'
        ]);

        $validated['is_approved'] = $request->has('is_approved');

        Testimonial::create($validated);

        return redirect()->route('cms.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('cms.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'role_company' => 'nullable|string|max:255',
            'message' => 'required|string',
            'is_approved' => 'boolean'
        ]);

        $validated['is_approved'] = $request->has('is_approved');

        $testimonial->update($validated);

        return redirect()->route('cms.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('cms.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }
}
