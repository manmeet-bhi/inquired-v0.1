<?php

namespace App\Helpers;

use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\Post;
use App\Models\SeoSetting;
use Illuminate\Support\Str;

class SeoHelper
{
    /**
     * Generate Google for Jobs compliant JobPosting schema
     */
    public static function generateJobSchema($job): array
    {
        if (!$job) {
            return [];
        }

        $companyName = $job->company ? $job->company->name : 'Inaquired';
        $companyWebsite = $job->company?->website ?: ($job->company?->slug ? route('company.show', $job->company->slug) : url('/'));
        $companyLogo = $job->company?->logo_url ?: asset('assets/logos/logo.png');

        $jobType = strtolower($job->type ?? '');
        $jobLevel = strtolower($job->level ?? '');
        $isInternship = $jobType === 'internship' || $jobLevel === 'internship' || $jobLevel === 'intern' || str_contains(strtolower($job->title ?? ''), 'intern');

        $employmentType = $isInternship ? 'INTERN' : match ($jobType) {
            'part-time', 'part_time' => 'PART_TIME',
            'contract', 'freelance' => 'CONTRACTOR',
            'temporary', 'temp' => 'TEMPORARY',
            default => 'FULL_TIME'
        };

        $workType = strtolower($job->work_type ?? '');
        $isRemote = $workType === 'remote';
        $isHybrid = $workType === 'hybrid';

        $rawDescription = !empty($job->content) ? $job->content : ($job->title . ' opportunity at ' . $companyName);
        $cleanDescription = strip_tags($rawDescription, '<p><br><ul><ol><li><strong><b><em><i><h3><h4>');
        if (empty(trim(strip_tags($cleanDescription)))) {
            $cleanDescription = '<p>' . htmlspecialchars($job->title . ' position at ' . $companyName . '.') . '</p>';
        }

        $datePosted = $job->created_at ? $job->created_at->toIso8601String() : date('c');
        $validThrough = $job->application_deadline
            ? $job->application_deadline->endOfDay()->toIso8601String()
            : ($job->created_at ? $job->created_at->addMonths(3)->toIso8601String() : date('c', strtotime('+90 days')));

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'JobPosting',
            'title' => $job->title,
            'description' => $cleanDescription,
            'identifier' => [
                '@type' => 'PropertyValue',
                'name' => $companyName,
                'value' => (string) ($job->job_id ?: $job->id),
            ],
            'datePosted' => $datePosted,
            'validThrough' => $validThrough,
            'employmentType' => $employmentType,
            'directApply' => true,
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name' => $companyName,
                'sameAs' => $companyWebsite,
                'logo' => $companyLogo,
            ],
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $job->location ?: 'Worldwide',
                    'addressCountry' => 'IN',
                ],
            ],
        ];

        if ($isRemote) {
            $schema['jobLocationType'] = 'TELECOMMUTE';
            $schema['applicantLocationRequirements'] = [
                '@type' => 'Country',
                'name' => 'Worldwide',
            ];
        } elseif ($isHybrid) {
            $schema['jobLocationType'] = 'HYBRID';
        }

        if ($job->salary_min && $job->salary_max) {
            $schema['baseSalary'] = [
                '@type' => 'MonetaryAmount',
                'currency' => $job->salary_currency ?: 'INR',
                'value' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => (float) $job->salary_min,
                    'maxValue' => (float) $job->salary_max,
                    'unitText' => 'YEAR',
                ],
            ];
        }

        if ($job->category) {
            $schema['industry'] = $job->category->name;
        }

        if (!empty($job->experience)) {
            $schema['experienceRequirements'] = $job->experience;
        }

        return array_filter($schema, fn ($val) => !is_null($val));
    }

    /**
     * Generate Google News & Article compliant BlogPosting schema
     */
    public static function generateBlogPostingSchema($post): array
    {
        if (!$post) {
            return [];
        }

        $siteUrl = url('/');
        $postUrl = route('blog.show', $post->slug ?? $post->id);
        $imageUrl = !empty($post->featured_image) ? media_url($post->featured_image) : asset('assets/logos/logo.png');

        $authorName = $post->author ?? 'Inaquired Editorial Team';
        $siteTitle = SeoSetting::get('site_title') ?: 'Inaquired';

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $postUrl,
            ],
            'headline' => $post->title,
            'description' => $post->excerpt ?: Str::limit(strip_tags($post->content ?? ''), 160),
            'image' => $imageUrl,
            'datePublished' => $post->published_at ? $post->published_at->toIso8601String() : ($post->created_at ? $post->created_at->toIso8601String() : date('c')),
            'dateModified' => $post->updated_at ? $post->updated_at->toIso8601String() : date('c'),
            'author' => [
                '@type' => 'Person',
                'name' => $authorName,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $siteTitle,
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets/logos/logo.png'),
                ],
            ],
        ];

        if (!empty($post->tags) && is_array($post->tags)) {
            $schema['keywords'] = implode(', ', $post->tags);
        }

        return $schema;
    }

    /**
     * Generate Organization schema for company profile pages
     */
    public static function generateCompanySchema($company): array
    {
        if (!$company) {
            return [];
        }

        $companyUrl = route('company.show', $company->slug ?: $company->id);
        $logoUrl = $company->logo_url ?: asset('assets/logos/logo.png');

        $sameAs = array_filter([
            $company->website,
            $company->linkedin_url,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $company->name,
            'url' => $company->website ?: $companyUrl,
            'logo' => $logoUrl,
            'description' => $company->description ?: ($company->name . ' - Career profiles and jobs on Inaquired'),
        ];

        if (!empty($sameAs)) {
            $schema['sameAs'] = array_values($sameAs);
        }

        if (!empty($company->address)) {
            $schema['address'] = [
                '@type' => 'PostalAddress',
                'addressLocality' => $company->address,
            ];
        }

        if (!empty($company->industry)) {
            $schema['knowsAbout'] = $company->industry;
        }

        return $schema;
    }

    /**
     * Generate CollectionPage and Breadcrumbs schema for Job Categories
     */
    public static function generateCategorySchema($category): array
    {
        if (!$category) {
            return [];
        }

        $categoryUrl = route('category.show', $category->slug ?: $category->id);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $category->name . ' Jobs & Opportunities',
            'url' => $categoryUrl,
            'description' => 'Browse and apply for active ' . $category->name . ' jobs, remote openings, and internships on Inaquired.',
            'breadcrumb' => [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => 'Home',
                        'item' => url('/'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => 'Categories',
                        'item' => route('categories'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 3,
                        'name' => $category->name,
                        'item' => $categoryUrl,
                    ],
                ],
            ],
        ];
    }

    /**
     * Generate Global WebSite Search schema for sitelinks searchbox
     */
    public static function generateWebsiteSchema(): array
    {
        $siteUrl = url('/');
        $siteTitle = SeoSetting::get('site_title') ?: 'Inaquired';

        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $siteTitle,
            'url' => $siteUrl,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => $siteUrl . '/jobs?search={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * Generate default Organization schema
     */
    public static function generateOrganizationSchema(): array
    {
        $siteUrl = url('/');
        $siteTitle = SeoSetting::get('site_title') ?: 'Inaquired';
        $favicon = SeoSetting::get('favicon');
        $logoUrl = $favicon ? media_url($favicon) : asset('assets/logos/logo.png');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteTitle,
            'alternateName' => 'inaquired',
            'url' => $siteUrl,
            'logo' => $logoUrl,
            'description' => SeoSetting::get('meta_description') ?: 'Leading career platform connecting talented professionals with opportunities worldwide',
            'sameAs' => [
                'https://linkedin.com/company/inaquired',
                'https://twitter.com/inaquired',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'availableLanguage' => ['English', 'Hindi'],
            ],
        ];
    }

    /**
     * Unified schema dispatcher by entity type and ID
     */
    public static function generateEntitySchema(string $type, int|string $id): ?array
    {
        return match ($type) {
            'job' => ($job = Job::with(['company', 'category'])->find($id)) ? self::generateJobSchema($job) : null,
            'post' => ($post = Post::find($id)) ? self::generateBlogPostingSchema($post) : null,
            'company' => ($company = Company::find($id)) ? self::generateCompanySchema($company) : null,
            'category' => ($category = JobCategory::find($id)) ? self::generateCategorySchema($category) : null,
            'website' => self::generateWebsiteSchema(),
            'organization' => self::generateOrganizationSchema(),
            default => null,
        };
    }

    /**
     * Breadcrumb schema builder
     */
    public static function generateBreadcrumbSchema(array $breadcrumbs): array
    {
        $items = [];
        foreach ($breadcrumbs as $index => $crumb) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $crumb['name'],
                'item' => $crumb['url'],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    /**
     * Calculate Page SEO score
     */
    public static function calculateSeoScore($page): int
    {
        $score = 0;

        if (!empty($page->meta_title)) {
            $titleLength = Str::length($page->meta_title);
            if ($titleLength >= 30 && $titleLength <= 60) {
                $score += 20;
            } elseif ($titleLength > 0) {
                $score += 10;
            }
        }

        if (!empty($page->meta_description)) {
            $descLength = Str::length($page->meta_description);
            if ($descLength >= 120 && $descLength <= 160) {
                $score += 20;
            } elseif ($descLength > 0) {
                $score += 10;
            }
        }

        if (!empty($page->meta_keywords)) {
            $score += 10;
        }

        if (!empty($page->og_title) && !empty($page->og_description)) {
            $score += 20;
        } elseif (!empty($page->og_title) || !empty($page->og_description)) {
            $score += 10;
        }

        if (!empty($page->canonical_url)) {
            $score += 10;
        }

        if (!empty($page->og_image)) {
            $score += 10;
        }

        if (!$page->noindex && !$page->nofollow) {
            $score += 10;
        }

        return $score;
    }
}
