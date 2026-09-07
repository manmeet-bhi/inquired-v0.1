<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Rahul Kumar',
                'role_company' => 'Full Stack Developer • Remote Tech',
                'message' => 'Inaquired cut through all the noise of traditional job boards. I found legitimate remote openings without fake recruiter spam and landed my Full Stack role within three weeks! The transparency regarding salary brackets and tech stacks is unmatched.',
                'days_ago' => 2,
                'is_featured' => true,
            ],
            [
                'name' => 'Pooja Sharma',
                'role_company' => 'UI/UX Designer • FinTech Innovators',
                'message' => 'As a fresher switching from a tier-3 college, finding real entry-level roles seemed impossible. The curated internships on Inaquired gave me direct links to apply without consultancy charges or endless resume traps.',
                'days_ago' => 4,
                'is_featured' => true,
            ],
            [
                'name' => 'Ankit Mehta',
                'role_company' => 'DevOps Engineer • CloudScale Solutions',
                'message' => 'The clean interface with category filtering saved me hours every week. I recommended Inaquired to all my colleagues during our company restructuring, and two of them already landed great DevOps roles.',
                'days_ago' => 6,
                'is_featured' => true,
            ],
            [
                'name' => 'Ananya Kapoor',
                'role_company' => 'Frontend Engineer • SaaS Labs',
                'message' => 'Inaquired makes finding legitimate job posts so simple. No middleman, no endless surveys. Applied to three roles and got two interview calls within a week! The direct career page redirects are a blessing.',
                'days_ago' => 7,
                'is_featured' => false,
            ],
            [
                'name' => 'Sameer Verma',
                'role_company' => 'Product Management Intern • GrowthX',
                'message' => 'The WhatsApp and Telegram channel alerts are a game changer. I saw an opening posted 10 minutes ago, applied immediately, and landed my first product management internship. Truly grateful!',
                'days_ago' => 9,
                'is_featured' => false,
            ],
            [
                'name' => 'Deepika Nair',
                'role_company' => 'Data Analyst • FinTech Global',
                'message' => 'Clean design without irritating popups. The direct career link redirect saves so much time compared to portals that require 10-step forms. Will definitely recommend Inaquired to batchmates looking for analytics roles.',
                'days_ago' => 11,
                'is_featured' => false,
            ],
            [
                'name' => 'Vikram Trivedi',
                'role_company' => 'Backend Golang Developer • Distributed Systems',
                'message' => 'Found my current remote job in a European timezone while based in India. Inaquired\'s remote filtering accurately tags worldwide eligible jobs, which saved me hundreds of hours of manual verification.',
                'days_ago' => 13,
                'is_featured' => false,
            ],
            [
                'name' => 'Manish Chauhan',
                'role_company' => 'Talent Partner • HyperGrowth Tech',
                'message' => 'As a recruiter, we appreciate Inaquired providing clean backlinks to our career portal without scrapers distorting job specs. The candidates who applied were highly relevant and well-informed.',
                'days_ago' => 15,
                'is_featured' => false,
            ],
            [
                'name' => 'Sneha Gupta',
                'role_company' => 'QA Automation Lead • NeoBank',
                'message' => 'The platform is blazing fast and doesn\'t ask for credit cards or subscriptions. Truly community focused. I check Inaquired every morning for fresh job additions across test automation and SDET roles.',
                'days_ago' => 17,
                'is_featured' => false,
            ],
            [
                'name' => 'Rohan Joshi',
                'role_company' => 'React Native Developer • AppWorks',
                'message' => 'Transitioned from native Android to React Native and was struggling to find hybrid openings in Bangalore. Found an incredible startup within 5 days of browsing Inaquired\'s mobile category.',
                'days_ago' => 19,
                'is_featured' => false,
            ],
            [
                'name' => 'Kavita Iyer',
                'role_company' => 'Technical Content Writer • Developer Relations',
                'message' => 'Non-engineering tech jobs are usually buried under random BPO listings on other sites. Inaquired had dedicated, high-paying tech writing and DevRel roles clearly categorized.',
                'days_ago' => 21,
                'is_featured' => false,
            ],
            [
                'name' => 'Aman Singhal',
                'role_company' => 'Cybersecurity Analyst • DefenseTech',
                'message' => 'Finding entry-level SOC analyst and infosec jobs used to be frustrating. Inaquired featured verified cybersecurity roles from MNCs with clear eligibility criteria.',
                'days_ago' => 23,
                'is_featured' => false,
            ],
            [
                'name' => 'Meera Patel',
                'role_company' => 'Product Designer • E-Commerce Unicorn',
                'message' => 'The UI/UX design opportunities listed here are from legitimate tech companies with mature design systems. Ended up landing an offer with a 40% salary hike!',
                'days_ago' => 25,
                'is_featured' => false,
            ],
            [
                'name' => 'Siddharth Rao',
                'role_company' => 'Machine Learning Engineer • AI Studio',
                'message' => 'Most portals label simple SQL tasks as AI/ML. Inaquired accurately separates GenAI, Computer Vision, and Data Science jobs from generic data entry.',
                'days_ago' => 27,
                'is_featured' => false,
            ],
            [
                'name' => 'Tanvi Saxena',
                'role_company' => 'HR Business Partner • PeopleOps',
                'message' => 'Inaquired has become our go-to recommendation for candidates whom we couldn\'t hire due to headcount limits. It gives genuine options without shady third-party intermediaries.',
                'days_ago' => 29,
                'is_featured' => false,
            ],
            [
                'name' => 'Aditya Kashyap',
                'role_company' => 'Cloud Architect • Enterprise Cloud',
                'message' => 'The precision of salary bands and location tags (Remote, Hybrid, Onsite) on Inaquired is the best I\'ve seen across Indian tech portals. Highly recommended!',
                'days_ago' => 31,
                'is_featured' => false,
            ],
            [
                'name' => 'Ritu Nambiar',
                'role_company' => 'Scrum Master • Agile Hive',
                'message' => 'Found an agile coach role with a multinational healthcare provider. The application link took me directly to Workday without 10 intermediate redirects.',
                'days_ago' => 34,
                'is_featured' => false,
            ],
            [
                'name' => 'Harsh Vardhan',
                'role_company' => 'Java Microservices Engineer • Banking Tech',
                'message' => 'I was laid off during tech downsizing and was feeling hopeless. Inaquired\'s daily updates gave me genuine leads, and I cleared an interview within 20 days.',
                'days_ago' => 37,
                'is_featured' => false,
            ],
            [
                'name' => 'Divya Kulkarni',
                'role_company' => 'Digital Marketing Strategist • AdTech Media',
                'message' => 'Performance marketing and SEO roles are verified and authentic. I was able to negotiate a fully remote package thanks to the market salary transparency here.',
                'days_ago' => 40,
                'is_featured' => false,
            ],
            [
                'name' => 'Karan Malhotra',
                'role_company' => 'Node.js Backend Engineer • CryptoFin',
                'message' => 'Clean typography, fast search, zero clickbait. Inaquired proves that a job portal can be simple and powerful without unnecessary gimmicks.',
                'days_ago' => 43,
                'is_featured' => false,
            ],
            [
                'name' => 'Shreya Ghosh',
                'role_company' => 'Business Analyst • Healthcare Systems',
                'message' => 'The distinction between IT services and product companies helped me narrow down exactly where I wanted to apply. Landed an amazing consulting role!',
                'days_ago' => 46,
                'is_featured' => false,
            ],
            [
                'name' => 'Naveen Reddy',
                'role_company' => 'Embedded Systems Engineer • Automotive IoT',
                'message' => 'Hardware and IoT roles are very hard to find on modern job boards. Inaquired surprised me with niche VLSI and firmware engineering listings.',
                'days_ago' => 49,
                'is_featured' => false,
            ],
            [
                'name' => 'Priyanka Sen',
                'role_company' => 'Customer Success Specialist • B2B SaaS',
                'message' => 'I made a career pivot from support to Customer Success Management. Inaquired’s listings helped me target high-growth SaaS startups eager for customer champions.',
                'days_ago' => 52,
                'is_featured' => false,
            ],
            [
                'name' => 'Abhishek Pandey',
                'role_company' => 'Site Reliability Engineer • Video Streaming',
                'message' => 'High availability, Kubernetes, and Terraform roles are very well-curated here. Direct application links saved me from ghost job postings.',
                'days_ago' => 55,
                'is_featured' => false,
            ],
            [
                'name' => 'Geeta Menon',
                'role_company' => 'Mobile App Developer • EdTech Hub',
                'message' => 'Applying for jobs on mobile browser used to be a nightmare on other platforms. Inaquired\'s responsive and lightweight layout makes mobile job hunting seamless.',
                'days_ago' => 58,
                'is_featured' => false,
            ],
            [
                'name' => 'Yashwant Chawla',
                'role_company' => 'Security Operations Engineer • CyberDef',
                'message' => 'Verified company career links give immense peace of mind against phishing job postings that have plagued the industry recently. Kudos to the Inaquired team!',
                'days_ago' => 61,
                'is_featured' => false,
            ],
            [
                'name' => 'Bhavna Sethi',
                'role_company' => 'Growth Marketer • D2C Brands',
                'message' => 'Subscribed to the WhatsApp alerts and got an alert for a Growth Marketing Lead. Applied within an hour and got scheduled for an interview the very next morning.',
                'days_ago' => 64,
                'is_featured' => false,
            ],
            [
                'name' => 'Mohit Agarwal',
                'role_company' => 'Frontend Specialist • Web3 Studio',
                'message' => 'Inaquired has the best filter for remote worldwide positions. I work with a US team from Pune with complete flexibility.',
                'days_ago' => 67,
                'is_featured' => false,
            ],
            [
                'name' => 'Swati Deshmukh',
                'role_company' => 'Graphic Designer • Digital Agency',
                'message' => 'Found an agency that values creative freedom and work-life balance. Thank you Inaquired for curating companies that genuinely care about culture.',
                'days_ago' => 70,
                'is_featured' => false,
            ],
            [
                'name' => 'Arun Sundaram',
                'role_company' => 'Database Administrator • Cloud Infotech',
                'message' => 'PostgreSQL and MySQL DBA roles are accurately categorized. The site loads in milliseconds, which makes browsing 50+ listings effortless.',
                'days_ago' => 73,
                'is_featured' => false,
            ],
            [
                'name' => 'Neha Bansal',
                'role_company' => 'Operations Lead • Logistics Tech',
                'message' => 'Finding ops roles in early stage startups is hard. Inaquired’s startup filter helped me find a fast-paced team where I lead city expansion.',
                'days_ago' => 76,
                'is_featured' => false,
            ],
            [
                'name' => 'Karthik Raja',
                'role_company' => 'Senior Python Developer • Data Analytics Corp',
                'message' => 'From internship to senior engineer, Inaquired has been my primary companion whenever I explored new opportunities. Truly grateful for this platform!',
                'days_ago' => 80,
                'is_featured' => false,
            ],
        ];

        // Clear existing demo testimonials to prevent duplicates
        Testimonial::truncate();

        foreach ($testimonials as $t) {
            Testimonial::create([
                'name' => $t['name'],
                'role_company' => $t['role_company'],
                'message' => $t['message'],
                'is_featured' => $t['is_featured'] ?? false,
                'created_at' => Carbon::now()->subDays($t['days_ago']),
                'updated_at' => Carbon::now()->subDays($t['days_ago']),
            ]);
        }

        // Clear caches so fresh data is visible immediately
        Cache::forget('testimonials_top_5');
        Cache::forget('testimonials_index_seo');
        for ($i = 1; $i <= 50; $i++) {
            Cache::forget("testimonials_page_{$i}");
        }
    }
}
