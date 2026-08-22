<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Company;
use App\Models\JobCategory;

class JobSeeder extends Seeder
{
    public function run()
    {
        // Create sample companies
        $companies = [
            ['name' => 'TechCorp', 'slug' => 'techcorp', 'is_active' => true],
            ['name' => 'InnovateLabs', 'slug' => 'innovatelabs', 'is_active' => true],
            ['name' => 'StartupHub', 'slug' => 'startuphub', 'is_active' => true],
            ['name' => 'GlobalTech', 'slug' => 'globaltech', 'is_active' => true],
            ['name' => 'DevStudio', 'slug' => 'devstudio', 'is_active' => true],
        ];

        foreach ($companies as $companyData) {
            Company::firstOrCreate(['slug' => $companyData['slug']], $companyData);
        }

        // Create sample categories
        $categories = [
            ['name' => 'Software Development', 'slug' => 'software-development', 'is_active' => true],
            ['name' => 'Data Science', 'slug' => 'data-science', 'is_active' => true],
            ['name' => 'Product Management', 'slug' => 'product-management', 'is_active' => true],
            ['name' => 'Design', 'slug' => 'design', 'is_active' => true],
            ['name' => 'Marketing', 'slug' => 'marketing', 'is_active' => true],
        ];

        foreach ($categories as $categoryData) {
            JobCategory::firstOrCreate(['slug' => $categoryData['slug']], $categoryData);
        }

        // Get created companies and categories
        $companyIds = Company::pluck('id')->toArray();
        $categoryIds = JobCategory::pluck('id')->toArray();

        // Sample jobs data
        $jobs = [
            // Remote Jobs
            [
                'title' => 'Senior Full Stack Developer',
                'slug' => 'senior-full-stack-developer-1',
                'company_id' => $companyIds[0],
                'category_id' => $categoryIds[0],
                'location' => 'Remote',
                'type' => 'full-time',
                'work_type' => 'remote',
                'level' => 'senior',
                'salary_min' => 800000,
                'salary_max' => 1200000,
                'content' => 'Join our team as a Senior Full Stack Developer and work on cutting-edge web applications.',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'React Developer',
                'slug' => 'react-developer-1',
                'company_id' => $companyIds[1],
                'category_id' => $categoryIds[0],
                'location' => 'Remote',
                'type' => 'full-time',
                'work_type' => 'remote',
                'level' => 'mid',
                'salary_min' => 600000,
                'salary_max' => 900000,
                'content' => 'Build amazing user interfaces with React and modern JavaScript.',
                'is_active' => true,
            ],
            [
                'title' => 'Data Scientist',
                'slug' => 'data-scientist-1',
                'company_id' => $companyIds[2],
                'category_id' => $categoryIds[1],
                'location' => 'Remote',
                'type' => 'full-time',
                'work_type' => 'remote',
                'level' => 'mid',
                'salary_min' => 700000,
                'salary_max' => 1100000,
                'content' => 'Analyze complex data sets and build machine learning models.',
                'is_featured' => true,
                'is_active' => true,
            ],
            
            // Onsite Jobs
            [
                'title' => 'Product Manager',
                'slug' => 'product-manager-1',
                'company_id' => $companyIds[3],
                'category_id' => $categoryIds[2],
                'location' => 'Bangalore, India',
                'type' => 'full-time',
                'work_type' => 'onsite',
                'level' => 'senior',
                'salary_min' => 1000000,
                'salary_max' => 1500000,
                'content' => 'Lead product strategy and work with cross-functional teams.',
                'is_active' => true,
            ],
            [
                'title' => 'UX Designer',
                'slug' => 'ux-designer-1',
                'company_id' => $companyIds[4],
                'category_id' => $categoryIds[3],
                'location' => 'Mumbai, India',
                'type' => 'full-time',
                'work_type' => 'onsite',
                'level' => 'mid',
                'salary_min' => 500000,
                'salary_max' => 800000,
                'content' => 'Design intuitive user experiences for web and mobile applications.',
                'is_active' => true,
            ],
            [
                'title' => 'Backend Developer',
                'slug' => 'backend-developer-1',
                'company_id' => $companyIds[0],
                'category_id' => $categoryIds[0],
                'location' => 'Delhi, India',
                'type' => 'full-time',
                'work_type' => 'onsite',
                'level' => 'junior',
                'salary_min' => 400000,
                'salary_max' => 700000,
                'content' => 'Build scalable backend systems and APIs.',
                'is_active' => true,
            ],
            
            // Internships
            [
                'title' => 'Software Development Intern',
                'slug' => 'software-development-intern-1',
                'company_id' => $companyIds[1],
                'category_id' => $categoryIds[0],
                'location' => 'Remote',
                'type' => 'internship',
                'work_type' => 'remote',
                'level' => 'entry',
                'salary_min' => 25000, // Monthly stipend
                'salary_max' => 25000,
                'content' => 'Learn software development while working on real projects.',
                'is_active' => true,
            ],
            [
                'title' => 'Data Science Intern',
                'slug' => 'data-science-intern-1',
                'company_id' => $companyIds[2],
                'category_id' => $categoryIds[1],
                'location' => 'Bangalore, India',
                'type' => 'internship',
                'work_type' => 'onsite',
                'level' => 'entry',
                'salary_min' => 20000,
                'salary_max' => 20000,
                'content' => 'Gain hands-on experience in data analysis and machine learning.',
                'is_active' => true,
            ],
            [
                'title' => 'Marketing Intern',
                'slug' => 'marketing-intern-1',
                'company_id' => $companyIds[3],
                'category_id' => $categoryIds[4],
                'location' => 'Mumbai, India',
                'type' => 'internship',
                'work_type' => 'hybrid',
                'level' => 'entry',
                'salary_min' => 15000,
                'salary_max' => 15000,
                'content' => 'Support marketing campaigns and learn digital marketing strategies.',
                'is_active' => true,
            ],
            [
                'title' => 'UI/UX Design Intern',
                'slug' => 'ui-ux-design-intern-1',
                'company_id' => $companyIds[4],
                'category_id' => $categoryIds[3],
                'location' => 'Remote',
                'type' => 'internship',
                'work_type' => 'remote',
                'level' => 'entry',
                'salary_min' => 18000,
                'salary_max' => 18000,
                'content' => 'Create beautiful and functional user interfaces.',
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($jobs as $jobData) {
            Job::firstOrCreate(['slug' => $jobData['slug']], $jobData);
        }
    }
}