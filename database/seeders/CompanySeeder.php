<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'Amazon',
                'slug' => 'amazon',
                'tagline' => 'Global leader in e-commerce, cloud computing (AWS), digital streaming, and artificial intelligence.',
                'description' => 'Amazon is guided by four principles: customer obsession rather than competitor focus, passion for invention, commitment to operational excellence, and long-term thinking.',
                'industry' => 'Cloud Computing, E-Commerce, Artificial Intelligence',
                'type' => 'mnc',
                'website' => 'https://www.amazon.com',
                'linkedin_url' => 'https://www.linkedin.com/company/amazon',
                'founded_year' => 1994,
                'is_active' => true,
            ],
            [
                'name' => 'Google',
                'slug' => 'google',
                'tagline' => 'Organizing the world\'s information and making it universally accessible and useful through AI and Search.',
                'description' => 'Google is a multinational technology company focusing on artificial intelligence, search engine technology, cloud computing, computer software, and consumer electronics.',
                'industry' => 'Internet, Software, Artificial Intelligence',
                'type' => 'mnc',
                'website' => 'https://about.google',
                'linkedin_url' => 'https://www.linkedin.com/company/google',
                'founded_year' => 1998,
                'is_active' => true,
            ],
            [
                'name' => 'Microsoft',
                'slug' => 'microsoft',
                'tagline' => 'Empowering every person and every organization on the planet to achieve more with intelligent cloud & enterprise tools.',
                'description' => 'Microsoft enables digital transformation for the era of an intelligent cloud and an intelligent edge. Its mission is to empower every person and organization on the planet to achieve more.',
                'industry' => 'Software, Cloud Computing, Productivity',
                'type' => 'mnc',
                'website' => 'https://www.microsoft.com',
                'linkedin_url' => 'https://www.linkedin.com/company/microsoft',
                'founded_year' => 1975,
                'is_active' => true,
            ],
            [
                'name' => 'Stripe',
                'slug' => 'stripe',
                'tagline' => 'Financial infrastructure for the internet — powering online payments, subscription billing, and global commerce.',
                'description' => 'Stripe builds economic infrastructure for the internet. Businesses of every size use our software to accept payments and manage their businesses online.',
                'industry' => 'Fintech, Financial Services, Payments',
                'type' => 'unicorn',
                'website' => 'https://stripe.com',
                'linkedin_url' => 'https://www.linkedin.com/company/stripe',
                'founded_year' => 2010,
                'is_active' => true,
            ],
            [
                'name' => 'Shopify',
                'slug' => 'shopify',
                'tagline' => 'The all-in-one global commerce platform empowering millions of businesses worldwide to sell anywhere.',
                'description' => 'Shopify provides trusted tools to start, grow, market, and manage a retail business of any size, making commerce better for everyone.',
                'industry' => 'E-Commerce, Software, SaaS',
                'type' => 'enterprise',
                'website' => 'https://www.shopify.com',
                'linkedin_url' => 'https://www.linkedin.com/company/shopify',
                'founded_year' => 2006,
                'is_active' => true,
            ],
            [
                'name' => 'Figma',
                'slug' => 'figma',
                'tagline' => 'Collaborative interface design tool connecting modern product teams from initial brainstorm to final code.',
                'description' => 'Figma is the leading collaborative design tool for teams building digital products, enabling seamless workflows between designers, developers, and product managers.',
                'industry' => 'Design, Collaboration, Developer Tools',
                'type' => 'startup',
                'website' => 'https://www.figma.com',
                'linkedin_url' => 'https://www.linkedin.com/company/figma',
                'founded_year' => 2012,
                'is_active' => true,
            ],
        ];

        foreach ($companies as $data) {
            Company::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
