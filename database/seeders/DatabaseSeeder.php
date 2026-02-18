<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\CaseStudy;
use App\Models\Client;
use App\Models\Faq;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ──
        User::create([
            'name' => 'Seeda Admin',
            'email' => 'admin@seeda.dev',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // ── Services ──
        $services = [
            ['title' => 'Custom Software Development', 'description' => 'Tailored software built for your unique business needs, from internal tools to customer-facing platforms.', 'icon' => 'code-bracket'],
            ['title' => 'AI & Machine Learning', 'description' => 'Harness the power of AI with predictive analytics, NLP, computer vision, and intelligent automation.', 'icon' => 'cpu-chip'],
            ['title' => 'Cloud Architecture & DevOps', 'description' => 'Scalable, reliable cloud infrastructure with CI/CD, containerization, and infrastructure as code.', 'icon' => 'cloud'],
            ['title' => 'Mobile App Development', 'description' => 'Native and cross-platform mobile applications for iOS and Android that users love.', 'icon' => 'device-phone-mobile'],
            ['title' => 'Web Application Development', 'description' => 'Modern, responsive web applications with rich UIs, real-time features, and blazing performance.', 'icon' => 'globe-alt'],
            ['title' => 'Technical Consulting', 'description' => 'Strategic technology advice: architecture reviews, tech stack selection, and modernization roadmaps.', 'icon' => 'light-bulb'],
        ];
        foreach ($services as $i => $s) {
            Service::create(array_merge($s, ['is_active' => true, 'sort_order' => $i]));
        }

        // ── Team Members ──
        $team = [
            ['name' => 'Marco Rossi', 'position' => 'CEO & Founder', 'bio' => 'Full-stack developer with 12+ years of experience leading engineering teams.'],
            ['name' => 'Giulia Bianchi', 'position' => 'CTO', 'bio' => 'Cloud and AI specialist with a passion for scalable systems.'],
            ['name' => 'Luca Verdi', 'position' => 'Lead Developer', 'bio' => 'Laravel and React expert who loves building clean, maintainable code.'],
            ['name' => 'Sofia Marino', 'position' => 'UI/UX Designer', 'bio' => 'Creating beautiful, user-centered designs that drive engagement.'],
        ];
        foreach ($team as $i => $t) {
            TeamMember::create(array_merge($t, ['is_active' => true, 'sort_order' => $i]));
        }

        // ── Case Studies ──
        $studies = [
            ['title' => 'E-Commerce Platform', 'category' => 'Web App', 'excerpt' => 'Built a scalable e-commerce platform handling 10K+ daily orders with real-time inventory.', 'color' => '#10B981', 'tags' => ['Laravel', 'Vue.js', 'AWS'], 'results' => ['300% revenue increase', '99.9% uptime', '2s avg load time', '50K+ users']],
            ['title' => 'Healthcare AI Assistant', 'category' => 'AI/ML', 'excerpt' => 'An AI-powered diagnostic assistant that helps doctors analyze medical images with 95% accuracy.', 'color' => '#3B82F6', 'tags' => ['Python', 'TensorFlow', 'GCP'], 'results' => ['95% accuracy', '60% faster diagnosis', '200+ hospitals', 'FDA approved']],
            ['title' => 'FinTech Mobile App', 'category' => 'Mobile', 'excerpt' => 'Cross-platform banking app with biometric auth, real-time transactions, and investment tracking.', 'color' => '#8B5CF6', 'tags' => ['Flutter', 'Node.js', 'Firebase'], 'results' => ['500K+ downloads', '4.8★ rating', 'PCI compliant', '< 100ms response']],
        ];
        foreach ($studies as $s) {
            CaseStudy::create(array_merge($s, ['is_active' => true, 'is_featured' => true, 'body' => '<p>Full case study coming soon.</p>']));
        }

        // ── Blog Posts ──
        $posts = [
            ['title' => 'Why Laravel is Still the Best PHP Framework in 2024', 'category' => 'Engineering', 'excerpt' => 'A deep dive into why Laravel continues to dominate the PHP ecosystem and what makes it ideal for modern web applications.', 'body' => '<p>Laravel has been the go-to PHP framework for over a decade...</p><h2>Developer Experience</h2><p>Eloquent ORM, Blade templates, and artisan commands make development a joy.</p>'],
            ['title' => 'Building AI-Powered Products: A Practical Guide', 'category' => 'AI/ML', 'excerpt' => 'From data collection to model deployment — a practical guide to building production AI systems.', 'body' => '<p>AI is transforming industries...</p><h2>Start with the Problem</h2><p>The best AI products start with a clear problem statement.</p>'],
            ['title' => 'The Art of Clean Code: Principles That Matter', 'category' => 'Engineering', 'excerpt' => 'Writing code is easy. Writing clean, maintainable code that your future self will thank you for? That takes practice.', 'body' => '<p>Clean code is not about following rules blindly...</p><h2>Meaningful Names</h2><p>Variable and function names should reveal intent.</p>'],
        ];
        foreach ($posts as $p) {
            BlogPost::create(array_merge($p, [
                'slug' => Str::slug($p['title']),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 30)),
                'tags' => ['software', 'development'],
            ]));
        }

        // ── Testimonials ──
        $testimonials = [
            ['client_name' => 'Andrea De Luca', 'position' => 'CEO', 'company' => 'TechFlow Italy', 'content' => 'Seeda transformed our business with a custom CRM that exactly fits our workflow. The team was professional, fast, and incredibly detailed.', 'rating' => 5],
            ['client_name' => 'Elena Colombo', 'position' => 'Product Manager', 'company' => 'DataVerse', 'content' => 'Their AI expertise is world-class. The predictive analytics system they built increased our forecast accuracy by 40%.', 'rating' => 5],
            ['client_name' => 'Thomas Weber', 'position' => 'CTO', 'company' => 'FinScape GmbH', 'content' => 'From architecture to deployment, Seeda delivered a rock-solid mobile banking app. Highly recommended for fintech projects.', 'rating' => 5],
        ];
        foreach ($testimonials as $i => $t) {
            Testimonial::create(array_merge($t, ['is_featured' => true, 'is_active' => true, 'sort_order' => $i]));
        }

        // ── FAQs ──
        $faqs = [
            ['question' => 'How long does a typical project take?', 'answer' => '<p>Project timelines vary depending on scope and complexity. A simple web application might take 4-8 weeks, while a complex enterprise system could take 3-6 months. We provide detailed timelines during discovery.</p>', 'category' => 'General'],
            ['question' => 'What is your pricing model?', 'answer' => '<p>We offer both fixed-price and time-and-materials pricing. For well-defined projects, we recommend fixed-price. For evolving products, T&M gives you more flexibility. We always provide transparent estimates upfront.</p>', 'category' => 'Billing'],
            ['question' => 'Do you provide ongoing support after launch?', 'answer' => '<p>Yes! We offer maintenance packages that include bug fixes, security updates, performance monitoring, and feature enhancements. Most of our clients continue working with us post-launch.</p>', 'category' => 'General'],
            ['question' => 'What technologies do you work with?', 'answer' => '<p>Our core stack includes Laravel, Vue.js/React, Python (AI/ML), Flutter (mobile), and AWS/GCP (cloud). We choose the best tools for each project rather than forcing a one-size-fits-all approach.</p>', 'category' => 'Technical'],
            ['question' => 'Can you work with our existing team?', 'answer' => '<p>Absolutely. We regularly embed our engineers into client teams for knowledge transfer and collaborative development. We\'re flexible with communication tools (Slack, Teams, Jira, etc.).</p>', 'category' => 'General'],
            ['question' => 'Do you sign NDAs?', 'answer' => '<p>Yes, we sign NDAs and confidentiality agreements before any project kick-off. Your intellectual property is always protected.</p>', 'category' => 'Legal'],
        ];
        foreach ($faqs as $i => $f) {
            Faq::create(array_merge($f, ['is_published' => true, 'sort_order' => $i]));
        }

        // ── Sample Client ──
        $client = Client::create([
            'name' => 'Acme Corporation',
            'email' => 'contact@acme.example',
            'phone' => '+39 02 9999 8888',
            'company' => 'Acme Corp',
        ]);

        // Client user
        User::create([
            'name' => 'John Acme',
            'email' => 'john@acme.example',
            'password' => Hash::make('password'),
            'role' => 'client',
            'client_id' => $client->id,
            'is_active' => true,
        ]);
    }
}
