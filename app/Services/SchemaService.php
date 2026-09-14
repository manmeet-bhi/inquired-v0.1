<?php

namespace App\Services;

use App\Helpers\SeoHelper;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\Post;

class SchemaService
{
    /**
     * Build JSON-LD string for a given entity or context
     */
    public function renderSchemaForContext(array $viewData): ?string
    {
        // 1. Explicit PageSeo custom schema takes highest priority
        if (!empty($viewData['pageSeo']->schema_json)) {
            return $viewData['pageSeo']->schema_json;
        }

        // 2. Dynamic Job / Internship
        if (isset($viewData['job']) && $viewData['job'] instanceof Job) {
            $schema = SeoHelper::generateJobSchema($viewData['job']);
            return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        // 3. Dynamic Blog Post
        if (isset($viewData['post']) && $viewData['post'] instanceof Post) {
            $schema = SeoHelper::generateBlogPostingSchema($viewData['post']);
            return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        // 4. Dynamic Company
        if (isset($viewData['company']) && $viewData['company'] instanceof Company) {
            $schema = SeoHelper::generateCompanySchema($viewData['company']);
            return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        // 5. Dynamic Category
        if (isset($viewData['category']) && $viewData['category'] instanceof JobCategory) {
            $schema = SeoHelper::generateCategorySchema($viewData['category']);
            return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        // 6. Global Schema Setting fallback
        if (!empty($viewData['seoSettings']['schema_json'])) {
            return $viewData['seoSettings']['schema_json'];
        }

        // 7. Default Organization Schema fallback
        $schema = SeoHelper::generateOrganizationSchema();
        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
