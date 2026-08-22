<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'logo_url' => $this->logo_url,
            'website' => $this->website,
            'linkedin_url' => $this->linkedin_url,
            'industry' => $this->industry,
            'type' => $this->type,
            'founded_year' => $this->founded_year,
            'address' => $this->address,
            'description' => $this->description,
            'jobs_count' => $this->whenCounted('jobs'),
        ];
    }
}
