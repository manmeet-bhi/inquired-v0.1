<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'type' => $this->type,
            'work_type' => $this->work_type,
            'level' => $this->level,
            'experience' => $this->experience,
            'location' => $this->location,
            'salary' => [
                'min' => $this->salary_min,
                'max' => $this->salary_max,
                'formatted' => $this->formatted_salary,
            ],
            'is_featured' => (bool) $this->is_featured,
            'views_count' => (int) $this->views_count,
            'application_url' => $this->application_url,
            'content' => $this->content,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'category' => new JobCategoryResource($this->whenLoaded('category')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
