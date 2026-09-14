<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobCategory;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Support\Str;

class JobCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Software Engineering',
                'slug' => 'software-engineering',
                'description' => 'Build robust backend systems, dynamic frontend web apps, distributed architectures, and modern cloud APIs.',
                'color' => '#2563eb',
                'sort_order' => 1,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>'
            ],
            [
                'name' => 'AI & Machine Learning',
                'slug' => 'ai-machine-learning',
                'description' => 'Develop deep learning pipelines, generative AI models, LLM agents, and neural network algorithms.',
                'color' => '#7c3aed',
                'sort_order' => 2,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>'
            ],
            [
                'name' => 'Data Science & Analytics',
                'slug' => 'data-science-analytics',
                'description' => 'Transform complex raw data into actionable predictive insights, metrics, pipelines, and dashboards.',
                'color' => '#0284c7',
                'sort_order' => 3,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>'
            ],
            [
                'name' => 'Cloud & DevOps Architecture',
                'slug' => 'cloud-devops-architecture',
                'description' => 'Orchestrate scalable infrastructure with Kubernetes, Docker, Terraform, AWS, Azure, and CI/CD pipelines.',
                'color' => '#059669',
                'sort_order' => 4,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>'
            ],
            [
                'name' => 'Product Management',
                'slug' => 'product-management',
                'description' => 'Define product visions, user journeys, agile sprints, and lead cross-functional delivery teams.',
                'color' => '#d97706',
                'sort_order' => 5,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>'
            ],
            [
                'name' => 'UI/UX & Product Design',
                'slug' => 'ui-ux-product-design',
                'description' => 'Craft pixel-perfect user interfaces, interactive wireframes, prototypes, and scalable design systems.',
                'color' => '#ec4899',
                'sort_order' => 6,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>'
            ],
            [
                'name' => 'Cybersecurity & InfoSec',
                'slug' => 'cybersecurity-infosec',
                'description' => 'Safeguard enterprise systems against cyber threats, penetration testing, compliance, and zero-trust security.',
                'color' => '#dc2626',
                'sort_order' => 7,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>'
            ],
            [
                'name' => 'Digital Marketing & Growth',
                'slug' => 'digital-marketing-growth',
                'description' => 'Drive customer acquisition, SEO optimization, performance marketing campaigns, and growth loops.',
                'color' => '#4f46e5',
                'sort_order' => 8,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>'
            ],
            [
                'name' => 'B2B Sales & Account Management',
                'slug' => 'sales-account-management',
                'description' => 'Accelerate revenue through enterprise closing, client relationship management, and sales development.',
                'color' => '#0d9488',
                'sort_order' => 9,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>'
            ],
            [
                'name' => 'Finance & Accounting',
                'slug' => 'finance-accounting',
                'description' => 'Manage corporate financial modeling, investment analysis, audit compliance, FP&A, and taxation.',
                'color' => '#16a34a',
                'sort_order' => 10,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
            ],
            [
                'name' => 'Human Resources & Talent',
                'slug' => 'hr-talent-acquisition',
                'description' => 'Recruit top tier engineering & business talent, lead people operations, culture, and employee benefits.',
                'color' => '#8b5cf6',
                'sort_order' => 11,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'
            ],
            [
                'name' => 'Content & Technical Writing',
                'slug' => 'content-technical-writing',
                'description' => 'Author developer documentation, API guides, compelling brand stories, case studies, and editorial content.',
                'color' => '#ea580c',
                'sort_order' => 12,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>'
            ],
            [
                'name' => 'Customer Success & Support',
                'slug' => 'customer-success-support',
                'description' => 'Guide clients through implementation, maximize retention, NPS scores, and deliver tier-1 support.',
                'color' => '#0891b2',
                'sort_order' => 13,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'
            ],
            [
                'name' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'description' => 'Architect native and cross-platform apps for iOS & Android with Flutter, React Native, Swift, and Kotlin.',
                'color' => '#6366f1',
                'sort_order' => 14,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>'
            ],
            [
                'name' => 'QA & Test Automation',
                'slug' => 'qa-test-automation',
                'description' => 'Ensure rock-solid software quality through automated test frameworks, Cypress, Playwright, and load testing.',
                'color' => '#10b981',
                'sort_order' => 15,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
            ],
            [
                'name' => 'Blockchain & Web3 Engineering',
                'slug' => 'blockchain-web3-engineering',
                'description' => 'Create decentralized applications, smart contract protocols, DeFi systems, and cryptographic security.',
                'color' => '#f59e0b',
                'sort_order' => 16,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>'
            ],
            [
                'name' => 'Operations & Supply Chain',
                'slug' => 'operations-supply-chain',
                'description' => 'Optimize business workflows, procurement, international logistics, warehouse ERPs, and vendor relations.',
                'color' => '#64748b',
                'sort_order' => 17,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>'
            ],
            [
                'name' => 'Healthcare & MedTech',
                'slug' => 'healthcare-medtech',
                'description' => 'Innovate in digital health platforms, electronic health records, telemedicine, and medical devices.',
                'color' => '#ef4444',
                'sort_order' => 18,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>'
            ],
            [
                'name' => 'Legal & Corporate Compliance',
                'slug' => 'legal-corporate-compliance',
                'description' => 'Structure commercial contracts, protect intellectual property, ensure GDPR/privacy, and mitigate risk.',
                'color' => '#475569',
                'sort_order' => 19,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>'
            ],
            [
                'name' => 'Engineering Leadership',
                'slug' => 'engineering-leadership',
                'description' => 'Lead high-impact engineering departments, mentor staff engineers, and steer long-term technical architecture.',
                'color' => '#3b82f6',
                'sort_order' => 20,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>'
            ],
            [
                'name' => 'Hardware & Embedded IoT',
                'slug' => 'hardware-embedded-iot',
                'description' => 'Design microcontrollers, firmware, robotics, PCB circuits, and connected smart IoT devices.',
                'color' => '#14b8a6',
                'sort_order' => 21,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>'
            ],
            [
                'name' => 'Education & EdTech Design',
                'slug' => 'education-edtech-design',
                'description' => 'Develop engaging interactive curricula, digital learning management software, and virtual classrooms.',
                'color' => '#84cc16',
                'sort_order' => 22,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-lime-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'
            ],
            [
                'name' => 'E-Commerce & Digital Retail',
                'slug' => 'e-commerce-digital-retail',
                'description' => 'Scale Shopify Plus stores, multi-channel marketplace logistics, merchandising, and checkout conversion.',
                'color' => '#f97316',
                'sort_order' => 23,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>'
            ],
            [
                'name' => 'Sustainability & CleanTech',
                'slug' => 'sustainability-cleantech',
                'description' => 'Drive renewable energy engineering, ESG reporting metrics, carbon accounting, and eco-friendly tech.',
                'color' => '#22c55e',
                'sort_order' => 24,
                'is_active' => true,
                'icon' => '<svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
            ]
        ];

        // Ensure companies exist for sample jobs
        $companies = [
            ['name' => 'Amazon', 'slug' => 'amazon', 'is_active' => true],
            ['name' => 'Google', 'slug' => 'google', 'is_active' => true],
            ['name' => 'Microsoft', 'slug' => 'microsoft', 'is_active' => true],
            ['name' => 'Stripe', 'slug' => 'stripe', 'is_active' => true],
            ['name' => 'Shopify', 'slug' => 'shopify', 'is_active' => true],
            ['name' => 'Figma', 'slug' => 'figma', 'is_active' => true],
        ];

        $companyModels = [];
        foreach ($companies as $comp) {
            $companyModels[] = Company::firstOrCreate(['slug' => $comp['slug']], $comp);
        }

        // Insert or update categories
        $categoryModels = [];
        foreach ($categories as $cat) {
            $category = JobCategory::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
            $categoryModels[] = $category;
        }

        // Create realistic sample jobs across categories so counts are active
        $sampleJobTitles = [
            'software-engineering' => ['Senior Backend Engineer (Go/Node)', 'Fullstack Web Architect', 'Staff Distributed Systems Engineer', 'Frontend React Lead'],
            'ai-machine-learning' => ['LLM Research Scientist', 'Machine Learning Infrastructure Engineer', 'Computer Vision Specialist', 'Generative AI Developer'],
            'data-science-analytics' => ['Senior Data Scientist', 'Business Intelligence Analyst', 'Data Pipeline Engineer', 'Analytics Engineer'],
            'cloud-devops-architecture' => ['Principal Cloud DevOps Architect', 'Site Reliability Engineer (SRE)', 'Kubernetes Platform Engineer', 'AWS Cloud Consultant'],
            'product-management' => ['Principal Product Manager', 'Group Product Manager (Growth)', 'Technical Product Manager', 'Associate Product Manager'],
            'ui-ux-product-design' => ['Senior Product Designer', 'Design Systems Lead', 'UI/UX Interaction Designer', 'UX Researcher'],
            'cybersecurity-infosec' => ['Senior Security Engineer', 'Penetration Tester & Red Teamer', 'SOC Security Analyst', 'Compliance & InfoSec Officer'],
            'digital-marketing-growth' => ['Director of Growth Marketing', 'Senior SEO Strategist', 'Paid Acquisition Manager', 'Lifecycle Marketing Specialist'],
            'sales-account-management' => ['Enterprise Account Executive', 'Strategic Partnerships Director', 'Sales Development Representative', 'Account Manager'],
            'finance-accounting' => ['Senior Financial Analyst', 'Head of FP&A', 'Corporate Accounting Manager', 'Tax & Compliance Specialist'],
            'hr-talent-acquisition' => ['Senior Tech Recruiter', 'Head of People Operations', 'Talent Brand Specialist', 'HR Business Partner'],
            'content-technical-writing' => ['Lead Technical Writer', 'Developer Documentation Specialist', 'Senior Content Strategist', 'Copywriter'],
            'customer-success-support' => ['Enterprise Customer Success Manager', 'Support Engineering Lead', 'Client Onboarding Specialist', 'Customer Experience Director'],
            'mobile-app-development' => ['Senior iOS Developer (Swift)', 'Staff Android Engineer (Kotlin)', 'Lead Flutter Developer', 'React Native Engineer'],
            'qa-test-automation' => ['Senior QA Automation Lead', 'SDET (Software Development Engineer in Test)', 'Performance & Load Testing Specialist', 'QA Test Engineer'],
            'blockchain-web3-engineering' => ['Senior Solidity Protocol Engineer', 'Rust Blockchain Developer', 'DeFi Smart Contract Auditor', 'Web3 Fullstack Engineer'],
            'operations-supply-chain' => ['Supply Chain Operations Manager', 'Logistics Analyst', 'Procurement Specialist', 'Operations Lead'],
            'healthcare-medtech' => ['Healthcare Data Architect', 'Health Tech Product Manager', 'Clinical Systems Engineer', 'Biotech Software Developer'],
            'legal-corporate-compliance' => ['Corporate Legal Counsel', 'Privacy & Data Governance Counsel', 'Contracts Manager', 'Regulatory Compliance Lead'],
            'engineering-leadership' => ['VP of Engineering', 'Director of Software Engineering', 'Engineering Manager (Core Platform)', 'Head of Technology'],
            'hardware-embedded-iot' => ['Embedded Firmware Engineer', 'IoT Hardware Systems Architect', 'Robotics Software Engineer', 'PCB Design Specialist'],
            'education-edtech-design' => ['EdTech Learning Experience Designer', 'Curriculum Engineering Specialist', 'E-Learning Platform Developer', 'Instructional Designer'],
            'e-commerce-digital-retail' => ['E-Commerce Growth Manager', 'Shopify Plus Solutions Architect', 'Digital Merchandising Lead', 'Retail Operations Manager'],
            'sustainability-cleantech' => ['CleanTech Software Engineer', 'ESG Data Analyst', 'Renewable Energy Systems Specialist', 'Carbon Accounting Tech Lead']
        ];

        foreach ($categoryModels as $index => $category) {
            $titles = $sampleJobTitles[$category->slug] ?? ['Senior Specialist', 'Lead Professional', 'Associate'];
            foreach ($titles as $jIndex => $title) {
                $comp = $companyModels[($index + $jIndex) % count($companyModels)];
                $slug = Str::slug($title) . '-' . $category->id . '-' . ($jIndex + 1);
                
                Job::firstOrCreate(
                    ['slug' => $slug],
                    [
                        'title' => $title,
                        'slug' => $slug,
                        'company_id' => $comp->id,
                        'category_id' => $category->id,
                        'location' => $jIndex % 2 === 0 ? 'Remote' : 'Bangalore, India',
                        'type' => 'full-time',
                        'work_type' => $jIndex % 2 === 0 ? 'remote' : ($jIndex % 3 === 0 ? 'hybrid' : 'onsite'),
                        'level' => $jIndex === 0 ? 'senior' : ($jIndex === 1 ? 'lead' : 'mid'),
                        'salary_min' => 900000 + ($jIndex * 200000),
                        'salary_max' => 1600000 + ($jIndex * 400000),
                        'content' => "Exciting opportunity to join as a {$title}. Work with modern tools and a high-impact team.",
                        'is_featured' => ($jIndex === 0),
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
