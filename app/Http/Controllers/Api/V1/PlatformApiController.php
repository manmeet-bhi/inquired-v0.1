<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\JobCategoryResource;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PlatformApiController extends Controller
{
    /**
     * Get active companies.
     */
    public function companies(Request $request): AnonymousResourceCollection
    {
        $query = Company::where('is_active', true)
            ->withCount(['jobs' => function ($q) {
                $q->where('is_active', true);
            }]);

        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $companies = $query->orderBy('name')->paginate(min((int) $request->get('per_page', 20), 50));
        return CompanyResource::collection($companies);
    }

    /**
     * Get active categories.
     */
    public function categories(Request $request): AnonymousResourceCollection
    {
        $categories = JobCategory::where('is_active', true)
            ->withCount(['jobs' => function ($q) {
                $q->where('is_active', true);
            }])
            ->orderBy('name')
            ->get();

        return JobCategoryResource::collection($categories);
    }

    /**
     * Get overall platform statistics.
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'total_active_jobs' => Job::where('is_active', true)->count(),
                'total_active_internships' => Job::where('is_active', true)->where('type', 'internship')->count(),
                'total_companies' => Company::where('is_active', true)->count(),
                'total_categories' => JobCategory::where('is_active', true)->count(),
            ],
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
