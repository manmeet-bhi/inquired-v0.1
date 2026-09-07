<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('role_company', 'LIKE', "%{$search}%")
                  ->orWhere('message', 'LIKE', "%{$search}%");
            });
        }

        $testimonials = $query->paginate(20)->withQueryString();
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
            'role_company' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Testimonial::create($validated);
        $this->clearTestimonialCache();

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
            'role_company' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $testimonial->update($validated);
        $this->clearTestimonialCache();

        return redirect()->route('cms.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        $this->clearTestimonialCache();

        return redirect()->route('cms.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }

    protected function clearTestimonialCache(): void
    {
        Cache::forget('testimonials_top_5');
        // Clear paginated caches
        for ($i = 1; $i <= 50; $i++) {
            Cache::forget("testimonials_page_{$i}");
        }
    }
}
