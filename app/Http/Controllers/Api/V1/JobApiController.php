<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JobApiController extends Controller
{
    /**
     * Display a paginated listing of jobs.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Job::with(['company', 'category'])
            ->where('is_active', true);

        // Search query
        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhereHas('company', function ($companyQuery) use ($search) {
                      $companyQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by job type (full-time, part-time, internship)
        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        // Filter by work type (remote, hybrid, onsite)
        if ($request->filled('work_type')) {
            $query->where('work_type', $request->get('work_type'));
        }

        // Filter by experience level
        if ($request->filled('level')) {
            $query->where('level', $request->get('level'));
        }

        // Filter by category slug
        if ($request->filled('category')) {
            $categorySlug = $request->get('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Filter by company slug
        if ($request->filled('company')) {
            $companySlug = $request->get('company');
            $query->whereHas('company', function ($q) use ($companySlug) {
                $q->where('slug', $companySlug);
            });
        }

        // Filter by featured
        if ($request->has('featured')) {
            $isFeatured = filter_var($request->get('featured'), FILTER_VALIDATE_BOOLEAN);
            $query->where('is_featured', $isFeatured);
        }

        // Sort order
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('is_featured', 'desc')->oldest();
                break;
            case 'salary-desc':
                $query->orderBy('is_featured', 'desc')->orderByRaw('COALESCE(salary_max, 0) DESC');
                break;
            case 'salary-asc':
                $query->orderBy('is_featured', 'desc')->orderByRaw('COALESCE(salary_min, 0) ASC');
                break;
            default: // newest
                $query->orderBy('is_featured', 'desc')->latest();
                break;
        }

        $perPage = min((int) $request->get('per_page', 15), 50);
        $jobs = $query->paginate($perPage);

        return JobResource::collection($jobs);
    }

    /**
     * Display the specified job.
     */
    public function show(int $id): JobResource
    {
        $job = Job::with(['company', 'category'])
            ->where('is_active', true)
            ->findOrFail($id);

        return new JobResource($job);
    }

    /**
     * Display internships only.
     */
    public function internships(Request $request): AnonymousResourceCollection
    {
        $request->merge(['type' => 'internship']);
        return $this->index($request);
    }
}
