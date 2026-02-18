<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Admin User ---
        User::create([
            'name' => 'Admin',
            'email' => 'admin@seeda.dev',
            'password' => Hash::make('password'),
        ]);

        // --- Services ---
        $services = [
            [
                'title' => 'Custom Software Development',
                'slug' => 'custom-software',
                'icon' => 'Code2',
                'description' => 'End-to-end development of bespoke software solutions tailored to your business needs.',
                'features' => ['Full-stack web applications', 'API design & integration', 'Legacy system modernization', 'Performance optimization'],
                'sort_order' => 1,
            ],
            [
                'title' => 'AI & Machine Learning',
                'slug' => 'ai-machine-learning',
                'icon' => 'BrainCircuit',
                'description' => 'Harness the power of AI to automate processes, extract insights, and build intelligent products.',
                'features' => ['Predictive analytics', 'Natural language processing', 'Computer vision solutions', 'ML model deployment'],
                'sort_order' => 2,
            ],
            [
                'title' => 'Cloud & DevOps',
                'slug' => 'cloud-devops',
                'icon' => 'Cloud',
                'description' => 'Scalable cloud architectures and streamlined DevOps pipelines for reliable, fast deployments.',
                'features' => ['AWS / GCP / Azure setup', 'CI/CD pipeline automation', 'Infrastructure as Code', 'Monitoring & alerting'],
                'sort_order' => 3,
            ],
            [
                'title' => 'Product Strategy & Design',
                'slug' => 'product-strategy',
                'icon' => 'Lightbulb',
                'description' => 'From idea to launch — we help you validate, design, and build products users love.',
                'features' => ['Product discovery workshops', 'UX/UI design', 'Rapid prototyping', 'User research & testing'],
                'sort_order' => 4,
            ],
            [
                'title' => 'Mobile App Development',
                'slug' => 'mobile-development',
                'icon' => 'Palette',
                'description' => 'Native and cross-platform mobile applications that deliver exceptional user experiences.',
                'features' => ['iOS & Android development', 'React Native / Flutter', 'App Store optimization', 'Push notifications & analytics'],
                'sort_order' => 5,
            ],
        ];

        foreach ($services as $s) {
            Service::create($s);
        }

        // --- Case Studies ---
        $caseStudies = [
            [
                'title' => 'FinPay — Digital Banking Platform',
                'slug' => 'fintech-platform',
                'category' => 'FinTech',
                'tags' => ['React', 'Node.js', 'AWS', 'PostgreSQL'],
                'excerpt' => 'Built a real-time digital banking platform handling 50K+ daily transactions with sub-200ms response times.',
                'challenge' => 'The client needed a secure, high-performance platform for thousands of concurrent transactions.',
                'solution' => 'Microservices architecture on AWS with event-driven processing and real-time fraud detection.',
                'results' => ['50K+ daily transactions', '99.99% uptime', '40% cost reduction', 'PCI-DSS Level 1'],
                'color' => '#16A34A',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'MediScan — AI Diagnostic Assistant',
                'slug' => 'healthcare-ai',
                'category' => 'Healthcare',
                'tags' => ['Python', 'TensorFlow', 'React', 'GCP'],
                'excerpt' => 'AI-powered diagnostic tool that helps radiologists detect anomalies 3x faster with 97% accuracy.',
                'challenge' => 'Radiologists overwhelmed by increasing scan volumes and higher risk of missed diagnoses.',
                'solution' => 'Deep learning model trained on 500K+ annotated images with an intuitive highlighting interface.',
                'results' => ['97% accuracy', '3x faster workflow', '10K+ scans/month', '12 hospitals'],
                'color' => '#2563EB',
                'sort_order' => 2,
            ],
            [
                'title' => 'RouteIQ — Logistics Optimization',
                'slug' => 'logistics-saas',
                'category' => 'Logistics',
                'tags' => ['Next.js', 'Python', 'Kubernetes', 'ML'],
                'excerpt' => 'Intelligent route optimization reducing delivery times by 25% and fuel costs by 18%.',
                'challenge' => 'Millions lost annually due to inefficient routing and poor fleet visibility.',
                'solution' => 'Real-time ML optimization engine adjusting routes based on traffic, weather, and priorities.',
                'results' => ['25% faster deliveries', '18% fuel savings', '$2.4M annual savings', '500+ vehicles tracked'],
                'color' => '#9333EA',
                'sort_order' => 3,
            ],
            [
                'title' => 'NordShop — E-Commerce Replatform',
                'slug' => 'ecommerce-replatform',
                'category' => 'E-Commerce',
                'tags' => ['React', 'GraphQL', 'Shopify', 'Vercel'],
                'excerpt' => 'Headless architecture replatform boosting page speed by 60% and conversion rates by 35%.',
                'challenge' => 'Monolithic platform was slow and unable to support rapid global growth.',
                'solution' => 'React Storefront on Vercel with Shopify commerce and CDN-first edge caching.',
                'results' => ['60% faster pages', '35% conversion boost', '8 markets', '45% mobile revenue up'],
                'color' => '#EA580C',
                'sort_order' => 4,
            ],
            [
                'title' => 'Iran Lobby — Advocacy PWA',
                'slug' => 'iran-lobby',
                'category' => 'Mobile / PWA',
                'tags' => ['Next.js', 'PWA', 'Node.js', 'i18n'],
                'excerpt' => 'Full-stack PWA for political advocacy with offline support and RTL/LTR toggle.',
                'challenge' => 'Advocates needed a tool that works in low-connectivity areas with multiple scripts.',
                'solution' => 'PWA with custom service worker for offline and granular RTL localization system.',
                'results' => ['100% PWA score', 'Offline access', '20K+ missions', 'Bilingual En/Fa'],
                'color' => '#059669',
                'sort_order' => 5,
            ],
            [
                'title' => 'FastingApp — Health Companion',
                'slug' => 'fasting-app',
                'category' => 'Mobile',
                'tags' => ['React Native', 'Laravel', 'Firebase', 'PWA'],
                'excerpt' => 'Intermittent fasting tracker with personalized coaching and gamified health streaks.',
                'challenge' => 'Users struggled with complex health trackers; the goal was a minimalist experience.',
                'solution' => 'Mobile-first experience with custom charting and notification-driven engagement.',
                'results' => ['4.8/5 rating', '65% retention', 'Habit coaching', 'Cross-device sync'],
                'color' => '#F59E0B',
                'sort_order' => 6,
            ],
            [
                'title' => 'EnergyFlow — Predictive Maintenance',
                'slug' => 'energy-ds',
                'category' => 'Data Science',
                'tags' => ['Python', 'Scikit-Learn', 'PowerBI', 'AWS'],
                'excerpt' => 'ML model predicting equipment failure up to 48 hours in advance, reducing downtime by 30%.',
                'challenge' => 'Unplanned downtime costing millions; sensor data not leveraged for predictions.',
                'solution' => 'Custom anomaly detection pipeline processing real-time sensor streams.',
                'results' => ['30% less downtime', '92% recall', 'Real-time monitoring', 'Automated alerts'],
                'color' => '#7C3AED',
                'sort_order' => 7,
            ],
            [
                'title' => 'Pulse — Sentiment AI',
                'slug' => 'sentiment-ds',
                'category' => 'Data Science',
                'tags' => ['PyTorch', 'HuggingFace', 'React', 'FastAPI'],
                'excerpt' => 'NLP platform analyzing customer feedback across social channels in real-time.',
                'challenge' => 'Marketing teams manually reading thousands of comments, missing negative trends.',
                'solution' => 'Fine-tuned transformer model with real-time dashboard and category alerts.',
                'results' => ['Instant trend detection', '95% accuracy', '80% faster response', '10+ API integrations'],
                'color' => '#EC4899',
                'sort_order' => 8,
            ],
        ];

        foreach ($caseStudies as $cs) {
            CaseStudy::create($cs);
        }

        // --- Team Members ---
        $team = [
            ['name' => 'Siavash Akbarzadeh', 'role' => 'Founder & CEO', 'bio' => 'Full-stack architect with 10+ years in enterprise systems.', 'linkedin' => '#', 'sort_order' => 1],
            ['name' => 'Elena Rossi', 'role' => 'Lead Designer', 'bio' => 'UX/UI specialist creating intuitive digital experiences.', 'linkedin' => '#', 'sort_order' => 2],
            ['name' => 'Marco Bianchi', 'role' => 'Senior Backend Engineer', 'bio' => 'Microservices and cloud infrastructure expert.', 'linkedin' => '#', 'sort_order' => 3],
            ['name' => 'Sara Ahmadi', 'role' => 'Data Scientist', 'bio' => 'ML/AI researcher focused on NLP and deep learning.', 'linkedin' => '#', 'sort_order' => 4],
            ['name' => 'Luca Verdi', 'role' => 'Frontend Engineer', 'bio' => 'React and TypeScript specialist obsessed with performance.', 'linkedin' => '#', 'sort_order' => 5],
            ['name' => 'Giulia Ferrari', 'role' => 'Project Manager', 'bio' => 'Agile PM ensuring projects ship on time and on scope.', 'linkedin' => '#', 'sort_order' => 6],
        ];

        foreach ($team as $t) {
            TeamMember::create($t);
        }
    }
}
