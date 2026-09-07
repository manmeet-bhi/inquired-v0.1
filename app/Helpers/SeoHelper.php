<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class SeoHelper
{
    public static function generateJobSchema($job)
    {
        $companyName = $job->company ? $job->company->name : 'Inaquired';
        $companyWebsite = $job->company?->website ?: url('/');
        $companyLogo = $job->company?->logo_url ?: asset('assets/logos/logo.png');

        $isRemote = strtolower($job->work_type) === 'remote';

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'JobPosting',
            'title' => $job->title,
            'description' => strip_tags($job->content ?? ''),
            'identifier' => [
                '@type' => 'PropertyValue',
                'name' => $companyName,
                'value' => (string) $job->id
            ],
            'datePosted' => $job->created_at ? $job->created_at->format('Y-m-d') : date('Y-m-d'),
            'validThrough' => $job->application_deadline ? $job->application_deadline->format('Y-m-d') : ($job->created_at ? $job->created_at->addMonths(3)->format('Y-m-d') : date('Y-m-d', strtotime('+90 days'))),
            'employmentType' => strtoupper(str_replace('-', '_', $job->type ?: 'FULL_TIME')),
            'workHours' => $job->type === 'part-time' ? 'PART_TIME' : 'FULL_TIME',
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name' => $companyName,
                'sameAs' => $companyWebsite,
                'logo' => $companyLogo
            ],
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $job->location ?: 'Worldwide',
                    'addressCountry' => 'IN'
                ]
            ],
            'baseSalary' => ($job->salary_min && $job->salary_max) ? [
                '@type' => 'MonetaryAmount',
                'currency' => $job->salary_currency ?: 'INR',
                'value' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => (float) $job->salary_min,
                    'maxValue' => (float) $job->salary_max,
                    'unitText' => 'YEAR'
                ]
            ] : null,
            'industry' => $job->category ? $job->category->name : null,
            'skills' => is_array($job->skills) ? implode(', ', $job->skills) : (is_string($job->skills) ? $job->skills : null)
        ];

        if ($isRemote) {
            $schema['jobLocationType'] = 'TELECOMMUTE';
            $schema['applicantLocationRequirements'] = [
                '@type' => 'Country',
                'name' => 'Worldwide'
            ];
        } else {
            $schema['jobLocationType'] = strtoupper($job->work_type ?: 'ONSITE');
        }

        return array_filter($schema, fn ($val) => !is_null($val));
    }

    public static function generateOrganizationSchema()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Inaquired',
            'alternateName' => 'inaquired',
            'url' => url('/'),
            'logo' => asset('assets/logos/logo.png'),
            'description' => 'Leading job portal connecting talented professionals with opportunities worldwide',
            'foundingDate' => '2024',
            'sameAs' => [
                'https://linkedin.com/company/inaquired',
                'https://twitter.com/inaquired'
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+91-XXXXXXXXXX',
                'contactType' => 'customer service',
                'availableLanguage' => ['English', 'Hindi']
            ]
        ];
    }

    public static function generateBreadcrumbSchema($breadcrumbs)
    {
        $items = [];
        foreach ($breadcrumbs as $index => $crumb) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $crumb['name'],
                'item' => $crumb['url']
            ];
        }
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ];
    }

    public static function calculateSeoScore($page)
    {
        $score = 0;
        
        // Title optimization (20 points)
        if ($page->meta_title) {
            $titleLength = Str::length($page->meta_title);
            if ($titleLength >= 30 && $titleLength <= 60) {
                $score += 20;
            } elseif ($titleLength > 0) {
                $score += 10;
            }
        }
        
        // Description optimization (20 points)
        if ($page->meta_description) {
            $descLength = Str::length($page->meta_description);
            if ($descLength >= 120 && $descLength <= 160) {
                $score += 20;
            } elseif ($descLength > 0) {
                $score += 10;
            }
        }
        
        // Keywords (10 points)
        if ($page->meta_keywords) {
            $score += 10;
        }
        
        // OG tags (20 points)
        if ($page->og_title && $page->og_description) {
            $score += 20;
        } elseif ($page->og_title || $page->og_description) {
            $score += 10;
        }
        
        // Canonical URL (10 points)
        if ($page->canonical_url) {
            $score += 10;
        }
        
        // OG Image (10 points)
        if ($page->og_image) {
            $score += 10;
        }
        
        // No negative SEO flags (10 points)
        if (!$page->noindex && !$page->nofollow) {
            $score += 10;
        }
        
        return $score;
    }
}
