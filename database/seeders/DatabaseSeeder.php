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
        $admin = User::updateOrCreate(
            ['email' => 'admin@seeda.dev'],
            [
                'name' => 'Seeda Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

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
        $clientUser = User::create([
            'name' => 'John Acme',
            'email' => 'john@acme.example',
            'password' => Hash::make('password'),
            'role' => 'client',
            'client_id' => $client->id,
            'is_active' => true,
        ]);

        // Support user
        $supportUser = User::create([
            'name' => 'Sara Support',
            'email' => 'sara@seeda.dev',
            'password' => Hash::make('password'),
            'role' => 'support',
            'is_active' => true,
        ]);

        $admin = User::where('role', 'admin')->first();

        // ── Tickets ──
        $tickets = [
            [
                'ticket_number' => 'TKT-00001',
                'client_id' => $client->id,
                'subject' => 'Login page not loading on mobile',
                'category' => 'bug',
                'description' => '<p>When I try to open the login page on my iPhone (Safari), the page is blank and shows a white screen. This started yesterday after the latest update.</p><p>Steps to reproduce:</p><ol><li>Open Safari on iPhone</li><li>Go to login page</li><li>Page is blank</li></ol>',
                'priority' => 'urgent',
                'status' => 'in_progress',
                'assigned_to' => $supportUser->id,
                'source' => 'portal',
                'sla_hours' => 4,
                'first_responded_at' => now()->subHours(22),
                'tags' => ['mobile', 'safari', 'login'],
                'created_at' => now()->subDay(),
                'replies' => [
                    ['user_id' => $supportUser->id, 'body' => '<p>Hi John, thanks for reporting this. I can reproduce the issue on Safari iOS. It looks like a CSS compatibility problem introduced in the last release. I\'m working on a fix now.</p>', 'is_internal_note' => false, 'hours_ago' => 22],
                    ['user_id' => $supportUser->id, 'body' => '<p>Root cause found: flexbox gap property not supported on older Safari. Need to add fallback.</p>', 'is_internal_note' => true, 'hours_ago' => 21],
                    ['user_id' => $clientUser->id, 'body' => '<p>Thank you for the quick response! Let me know when the fix is deployed.</p>', 'is_internal_note' => false, 'hours_ago' => 20],
                ],
            ],
            [
                'ticket_number' => 'TKT-00002',
                'client_id' => $client->id,
                'subject' => 'Add export to PDF feature for reports',
                'category' => 'feature',
                'description' => '<p>It would be great if we could export the monthly reports to PDF format. Currently we can only view them in the browser. This would help our accounting team process reports offline.</p>',
                'priority' => 'medium',
                'status' => 'open',
                'assigned_to' => null,
                'source' => 'portal',
                'sla_hours' => 24,
                'tags' => ['reports', 'pdf', 'export'],
                'created_at' => now()->subHours(6),
                'replies' => [],
            ],
            [
                'ticket_number' => 'TKT-00003',
                'client_id' => $client->id,
                'subject' => 'Invoice #INV-2024-042 incorrect amount',
                'category' => 'billing',
                'description' => '<p>The invoice INV-2024-042 shows €5,200 but the agreed amount for January was €4,800. Please review and issue a corrected invoice.</p>',
                'priority' => 'high',
                'status' => 'resolved',
                'assigned_to' => $admin->id,
                'source' => 'email',
                'sla_hours' => 8,
                'first_responded_at' => now()->subDays(3)->addHours(2),
                'satisfaction_rating' => 5,
                'satisfaction_comment' => 'Very fast response and the corrected invoice was issued the same day. Great support!',
                'tags' => ['billing', 'invoice'],
                'created_at' => now()->subDays(4),
                'replies' => [
                    ['user_id' => $admin->id, 'body' => '<p>Hi John, thank you for flagging this. You are correct — the extra €400 was due to a line item being duplicated. I\'ve issued a corrected invoice (INV-2024-042-R1) which is now available in your portal.</p>', 'is_internal_note' => false, 'hours_ago' => 72],
                    ['user_id' => $clientUser->id, 'body' => '<p>Got it, thank you so much for the quick fix!</p>', 'is_internal_note' => false, 'hours_ago' => 70],
                ],
            ],
            [
                'ticket_number' => 'TKT-00004',
                'client_id' => $client->id,
                'subject' => 'How to set up SSO with our Google Workspace?',
                'category' => 'question',
                'description' => '<p>We\'d like to enable Single Sign-On for our team using Google Workspace. Can you provide instructions or set this up for us?</p>',
                'priority' => 'low',
                'status' => 'closed',
                'assigned_to' => $supportUser->id,
                'source' => 'portal',
                'sla_hours' => 48,
                'first_responded_at' => now()->subDays(8)->addHours(5),
                'closed_at' => now()->subDays(6),
                'satisfaction_rating' => 4,
                'satisfaction_comment' => 'Good explanation, but could have included screenshots.',
                'tags' => ['sso', 'google', 'authentication'],
                'created_at' => now()->subDays(10),
                'replies' => [
                    ['user_id' => $supportUser->id, 'body' => '<p>Hi John! Setting up Google Workspace SSO is straightforward. Here are the steps:</p><ol><li>Go to Admin Console → Security → SSO</li><li>Add our application URL as a trusted service provider</li><li>Configure the SAML settings with the metadata URL we\'ll provide</li></ol><p>I\'ll send you the metadata URL shortly.</p>', 'is_internal_note' => false, 'hours_ago' => 192],
                    ['user_id' => $clientUser->id, 'body' => '<p>Thanks! I\'ve followed the steps. Everything works now.</p>', 'is_internal_note' => false, 'hours_ago' => 168],
                    ['user_id' => $supportUser->id, 'body' => '<p>Great to hear! Closing this ticket. Feel free to reopen if you need anything else.</p>', 'is_internal_note' => false, 'hours_ago' => 150],
                ],
            ],
            [
                'ticket_number' => 'TKT-00005',
                'client_id' => $client->id,
                'subject' => 'Cannot access admin panel — permission denied',
                'category' => 'access',
                'description' => '<p>I\'m getting a "403 Forbidden" error when trying to access the admin panel at /admin. My account is john@acme.example. This worked fine last week.</p>',
                'priority' => 'high',
                'status' => 'waiting',
                'assigned_to' => $supportUser->id,
                'source' => 'phone',
                'sla_hours' => 8,
                'first_responded_at' => now()->subHours(10),
                'tags' => ['access', 'permissions', '403'],
                'created_at' => now()->subHours(12),
                'replies' => [
                    ['user_id' => $supportUser->id, 'body' => '<p>Hi John, I\'ve checked your account permissions. It seems like your admin role was accidentally removed during a recent bulk permission update. I\'ve restored your access. Can you please try logging in again and confirm?</p>', 'is_internal_note' => false, 'hours_ago' => 10],
                    ['user_id' => $supportUser->id, 'body' => '<p>Note: This was caused by the role migration script running twice. Need to add idempotency check. CC: @dev team</p>', 'is_internal_note' => true, 'hours_ago' => 10],
                ],
            ],
            [
                'ticket_number' => 'TKT-00006',
                'client_id' => $client->id,
                'subject' => 'Dashboard is very slow to load',
                'category' => 'performance',
                'description' => '<p>The main dashboard takes about 12 seconds to load. It used to be instant. Started happening after last Tuesday\'s deployment. Please investigate.</p>',
                'priority' => 'medium',
                'status' => 'in_progress',
                'assigned_to' => $admin->id,
                'source' => 'portal',
                'sla_hours' => 12,
                'first_responded_at' => now()->subHours(3),
                'tags' => ['performance', 'dashboard', 'slow'],
                'created_at' => now()->subHours(8),
                'replies' => [
                    ['user_id' => $admin->id, 'body' => '<p>Hi John, thanks for reporting this. I\'ve profiled the dashboard and found that the revenue chart query is running a full table scan on invoices. I\'m adding proper database indexes now. You should see improvement within a few hours.</p>', 'is_internal_note' => false, 'hours_ago' => 3],
                ],
            ],
        ];

        foreach ($tickets as $ticketData) {
            $replies = $ticketData['replies'] ?? [];
            unset($ticketData['replies']);

            $ticket = \App\Models\Ticket::create($ticketData);

            foreach ($replies as $reply) {
                $hoursAgo = $reply['hours_ago'];
                unset($reply['hours_ago']);
                $ticket->replies()->create(array_merge($reply, [
                    'created_at' => now()->subHours($hoursAgo),
                    'updated_at' => now()->subHours($hoursAgo),
                ]));
            }
        }

        // ── Invoices & Payments ──
        $invoice1 = \App\Models\Invoice::create([
            'client_id' => $client->id,
            'invoice_number' => 'INV-2026-0001',
            'issue_date' => now()->subDays(45),
            'due_date' => now()->subDays(15),
            'subtotal' => 4800.00,
            'tax_rate' => 22,
            'tax_amount' => 1056.00,
            'total' => 5856.00,
            'amount_paid' => 5856.00,
            'balance_due' => 0,
            'status' => 'paid',
            'paid_at' => now()->subDays(20),
            'sent_at' => now()->subDays(44),
            'payment_terms' => 'Net 30',
            'currency' => 'EUR',
            'notes' => 'Website redesign — Phase 1',
        ]);
        $invoice1->items()->createMany([
            ['description' => 'Homepage Design & Development', 'quantity' => 1, 'unit_price' => 2500, 'total' => 2500],
            ['description' => 'Inner Pages (5x)', 'quantity' => 5, 'unit_price' => 350, 'total' => 1750],
            ['description' => 'SEO Setup', 'quantity' => 1, 'unit_price' => 550, 'total' => 550],
        ]);
        \App\Models\Payment::create([
            'invoice_id' => $invoice1->id,
            'client_id' => $client->id,
            'amount' => 5856.00,
            'payment_date' => now()->subDays(20),
            'method' => 'bank_transfer',
            'reference' => 'TXN-20260129-001',
        ]);

        $invoice2 = \App\Models\Invoice::create([
            'client_id' => $client->id,
            'invoice_number' => 'INV-2026-0002',
            'issue_date' => now()->subDays(10),
            'due_date' => now()->addDays(20),
            'subtotal' => 3200.00,
            'tax_rate' => 22,
            'tax_amount' => 704.00,
            'total' => 3904.00,
            'amount_paid' => 1500.00,
            'balance_due' => 2404.00,
            'status' => 'partial',
            'sent_at' => now()->subDays(9),
            'payment_terms' => 'Net 30',
            'currency' => 'EUR',
            'notes' => 'Monthly maintenance & support — February 2026',
        ]);
        $invoice2->items()->createMany([
            ['description' => 'Monthly Hosting & Maintenance', 'quantity' => 1, 'unit_price' => 800, 'total' => 800],
            ['description' => 'Feature Development (16 hours)', 'quantity' => 16, 'unit_price' => 85, 'total' => 1360],
            ['description' => 'SSL & Security Monitoring', 'quantity' => 1, 'unit_price' => 240, 'total' => 240],
            ['description' => 'Bug Fixes & QA', 'quantity' => 1, 'unit_price' => 800, 'total' => 800],
        ]);
        \App\Models\Payment::create([
            'invoice_id' => $invoice2->id,
            'client_id' => $client->id,
            'amount' => 1500.00,
            'payment_date' => now()->subDays(5),
            'method' => 'credit_card',
            'reference' => 'CC-20260213-042',
        ]);

        $invoice3 = \App\Models\Invoice::create([
            'client_id' => $client->id,
            'invoice_number' => 'INV-2026-0003',
            'issue_date' => now()->subDays(40),
            'due_date' => now()->subDays(10),
            'subtotal' => 1800.00,
            'tax_rate' => 22,
            'tax_amount' => 396.00,
            'total' => 2196.00,
            'amount_paid' => 0,
            'balance_due' => 2196.00,
            'status' => 'overdue',
            'sent_at' => now()->subDays(39),
            'reminder_sent_at' => now()->subDays(5),
            'payment_terms' => 'Net 30',
            'currency' => 'EUR',
            'notes' => 'Custom CRM Integration',
        ]);
        $invoice3->items()->createMany([
            ['description' => 'CRM API Integration', 'quantity' => 1, 'unit_price' => 1200, 'total' => 1200],
            ['description' => 'Data Migration', 'quantity' => 1, 'unit_price' => 600, 'total' => 600],
        ]);

        $invoice4 = \App\Models\Invoice::create([
            'client_id' => $client->id,
            'invoice_number' => 'INV-2026-0004',
            'issue_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 950.00,
            'tax_rate' => 22,
            'tax_amount' => 209.00,
            'total' => 1159.00,
            'amount_paid' => 0,
            'balance_due' => 1159.00,
            'status' => 'draft',
            'payment_terms' => 'Net 30',
            'currency' => 'EUR',
            'notes' => 'E-commerce plugin development',
        ]);
        $invoice4->items()->createMany([
            ['description' => 'WooCommerce Plugin Setup', 'quantity' => 1, 'unit_price' => 650, 'total' => 650],
            ['description' => 'Payment Gateway Integration', 'quantity' => 1, 'unit_price' => 300, 'total' => 300],
        ]);

        // ── Recurring Invoice ──
        \App\Models\RecurringInvoice::create([
            'client_id' => $client->id,
            'title' => 'Monthly Hosting & Maintenance',
            'frequency' => 'monthly',
            'amount' => 800.00,
            'tax_rate' => 22,
            'items' => [
                ['description' => 'Cloud Hosting', 'quantity' => 1, 'unit_price' => 450],
                ['description' => 'Maintenance & Monitoring', 'quantity' => 1, 'unit_price' => 350],
            ],
            'next_issue_date' => now()->startOfMonth()->addMonth(),
            'is_active' => true,
            'auto_send' => true,
            'notes' => 'Recurring monthly hosting and website maintenance.',
        ]);

        // ── Credit Note ──
        \App\Models\CreditNote::create([
            'client_id' => $client->id,
            'invoice_id' => $invoice1->id,
            'credit_number' => 'CN-2026-0001',
            'issue_date' => now()->subDays(18),
            'amount' => 350.00,
            'reason' => 'Overcharge on inner page count (billed 5, delivered 4). Credit for 1 unused page.',
            'status' => 'applied',
        ]);

        // ── Expenses ──
        $expenses = [
            ['user_id' => $admin->id, 'category' => 'hosting', 'description' => 'AWS EC2 — February 2026', 'amount' => 285.50, 'date' => now()->subDays(5), 'status' => 'approved', 'is_reimbursable' => false],
            ['user_id' => $admin->id, 'category' => 'software', 'description' => 'Figma Team — Annual License', 'amount' => 540.00, 'date' => now()->subDays(12), 'status' => 'approved', 'is_reimbursable' => false],
            ['user_id' => $supportUser->id, 'category' => 'subscription', 'description' => 'Slack Pro Plan', 'amount' => 89.00, 'date' => now()->subDays(8), 'status' => 'approved', 'is_reimbursable' => false],
            ['user_id' => $admin->id, 'category' => 'domain', 'description' => 'Renewal — seeda.dev (2 years)', 'amount' => 45.00, 'date' => now()->subDays(20), 'status' => 'approved', 'is_reimbursable' => false],
            ['user_id' => $supportUser->id, 'category' => 'training', 'description' => 'Laravel Certification Course', 'amount' => 299.00, 'date' => now()->subDays(3), 'status' => 'pending', 'is_reimbursable' => true],
            ['user_id' => $admin->id, 'category' => 'marketing', 'description' => 'Google Ads — February Campaign', 'amount' => 450.00, 'date' => now()->subDays(2), 'status' => 'pending', 'is_reimbursable' => false],
            ['user_id' => $supportUser->id, 'category' => 'hardware', 'description' => 'External Monitor — Dell 27"', 'amount' => 389.00, 'date' => now()->subDays(15), 'status' => 'reimbursed', 'is_reimbursable' => true],
            ['user_id' => $admin->id, 'category' => 'freelancer', 'description' => 'Contract — Logo design for client', 'amount' => 200.00, 'date' => now()->subDays(25), 'status' => 'approved', 'is_reimbursable' => false, 'project_id' => \App\Models\Project::first()?->id],
        ];

        foreach ($expenses as $expense) {
            \App\Models\Expense::create($expense);
        }

        // ══════════════════════════════════════
        // ── MARKETING ──
        // ══════════════════════════════════════

        // ── Campaigns ──
        $campaign1 = \App\Models\Campaign::create([
            'name' => 'Spring Web Development Sale',
            'type' => 'google_ads',
            'status' => 'active',
            'budget' => 2500.00,
            'spent' => 1840.00,
            'start_date' => now()->subDays(20),
            'end_date' => now()->addDays(10),
            'description' => 'Google Ads campaign targeting businesses needing website redesigns this spring.',
            'target_url' => 'https://seeda.dev/landing/spring-sale',
            'utm_source' => 'google',
            'utm_medium' => 'cpc',
            'utm_campaign' => 'spring_web_sale',
            'impressions' => 45200,
            'clicks' => 1280,
            'conversions' => 18,
            'revenue_generated' => 12500.00,
            'tags' => ['web-development', 'spring', 'sme'],
        ]);

        $campaign2 = \App\Models\Campaign::create([
            'name' => 'LinkedIn B2B Outreach',
            'type' => 'linkedin',
            'status' => 'active',
            'budget' => 1500.00,
            'spent' => 780.00,
            'start_date' => now()->subDays(15),
            'end_date' => now()->addDays(45),
            'description' => 'Targeting CTOs and IT managers of mid-sized companies for custom software solutions.',
            'target_url' => 'https://seeda.dev/enterprise',
            'utm_source' => 'linkedin',
            'utm_medium' => 'sponsored',
            'utm_campaign' => 'b2b_outreach_q1',
            'impressions' => 22000,
            'clicks' => 680,
            'conversions' => 8,
            'revenue_generated' => 6200.00,
            'tags' => ['b2b', 'enterprise', 'linkedin'],
        ]);

        $campaign3 = \App\Models\Campaign::create([
            'name' => 'SEO Content Strategy',
            'type' => 'seo',
            'status' => 'active',
            'budget' => 800.00,
            'spent' => 450.00,
            'start_date' => now()->subMonths(2),
            'description' => 'Organic content strategy: blog posts, case studies, and technical guides.',
            'utm_source' => 'organic',
            'utm_medium' => 'blog',
            'utm_campaign' => 'seo_content',
            'impressions' => 85000,
            'clicks' => 4200,
            'conversions' => 35,
            'revenue_generated' => 18000.00,
            'tags' => ['seo', 'content', 'organic'],
        ]);

        // ── Leads ──
        $leads = [
            ['name' => 'Marco Bianchi', 'email' => 'marco@techitalia.com', 'phone' => '+39 333 1234567', 'company' => 'TechItalia SRL', 'website' => 'https://techitalia.com', 'source' => 'google', 'status' => 'qualified', 'estimated_value' => 8500, 'assigned_to' => $admin->id, 'campaign_id' => $campaign1->id, 'utm_source' => 'google', 'utm_medium' => 'cpc', 'last_contacted_at' => now()->subDays(2), 'notes' => 'Interested in full website redesign. Has budget ready for Q1.'],
            ['name' => 'Elena Rossi', 'email' => 'elena@designstudio.it', 'phone' => '+39 340 9876543', 'company' => 'Design Studio Roma', 'source' => 'referral', 'status' => 'proposal', 'estimated_value' => 12000, 'assigned_to' => $admin->id, 'last_contacted_at' => now()->subDays(1), 'notes' => 'Referred by existing client. Needs custom CRM + website. Sent proposal on Feb 15.'],
            ['name' => 'Luca Ferrari', 'email' => 'luca@fastlogistics.eu', 'company' => 'FastLogistics EU', 'source' => 'linkedin', 'status' => 'negotiation', 'estimated_value' => 25000, 'assigned_to' => $admin->id, 'campaign_id' => $campaign2->id, 'utm_source' => 'linkedin', 'utm_medium' => 'sponsored', 'last_contacted_at' => now()->subHours(6), 'notes' => 'Enterprise logistics platform. Negotiating scope and timeline.'],
            ['name' => 'Anna Martinez', 'email' => 'anna@greenco.org', 'company' => 'GreenCo Foundation', 'source' => 'website', 'status' => 'new', 'estimated_value' => 3500, 'notes' => 'Non-profit needing a new donation platform. Filled contact form.'],
            ['name' => 'Thomas Weber', 'email' => 'thomas@webershop.de', 'company' => 'Weber Shop GmbH', 'source' => 'google', 'status' => 'contacted', 'estimated_value' => 6800, 'assigned_to' => $supportUser->id, 'campaign_id' => $campaign1->id, 'utm_source' => 'google', 'utm_medium' => 'cpc', 'last_contacted_at' => now()->subDays(3), 'notes' => 'E-commerce migration from Magento to WooCommerce.'],
            ['name' => 'Sophie Dupont', 'email' => 'sophie@frenchcafe.fr', 'company' => 'Le Petit Café', 'source' => 'social', 'status' => 'won', 'estimated_value' => 2800, 'assigned_to' => $admin->id, 'converted_at' => now()->subDays(5), 'notes' => 'Small restaurant website with online ordering. Converted!'],
            ['name' => 'James Park', 'email' => 'james@parkventures.io', 'company' => 'Park Ventures', 'source' => 'event', 'status' => 'lost', 'estimated_value' => 15000, 'notes' => 'Met at tech conference. Budget cut — postponed to next year.'],
            ['name' => 'Yuki Tanaka', 'email' => 'yuki@tokyotech.jp', 'company' => 'Tokyo Tech Inc.', 'source' => 'email', 'status' => 'new', 'estimated_value' => 9500, 'utm_source' => 'newsletter', 'utm_medium' => 'email', 'notes' => 'Received through newsletter. Interested in AI chatbot integration.'],
        ];

        foreach ($leads as $lead) {
            \App\Models\Lead::create($lead);
        }

        // ── Contact Submissions ──
        $submissions = [
            ['name' => 'Roberto Conti', 'email' => 'roberto@contilaw.it', 'phone' => '+39 06 5551234', 'company' => 'Conti & Partners', 'subject' => 'Need a new website', 'message' => 'We are a law firm in Rome and need a professional website redesign with client portal. Can you send us a quote?', 'source_page' => '/contact', 'status' => 'new', 'created_at' => now()->subHours(3)],
            ['name' => 'Maria Garcia', 'email' => 'maria@startupbarcelona.es', 'subject' => 'Mobile app development', 'message' => 'Hello! We are a startup in Barcelona looking for a development partner for our mobile app. We have wireframes ready. What are your rates?', 'source_page' => '/services/mobile', 'utm_source' => 'google', 'utm_medium' => 'organic', 'status' => 'read', 'created_at' => now()->subDays(1)],
            ['name' => 'Spam Bot', 'email' => 'buy@cheapmeds.xyz', 'subject' => 'GET RICH QUICK!!!', 'message' => 'Buy our amazing products now at cheapmeds.xyz for incredible prices!!!', 'source_page' => '/contact', 'status' => 'spam', 'ip_address' => '203.0.113.42', 'created_at' => now()->subDays(2)],
            ['name' => 'Ahmed Hassan', 'email' => 'ahmed@dubaiconstruct.ae', 'company' => 'Dubai Construct LLC', 'subject' => 'ERP System Inquiry', 'message' => 'We need a complete ERP system for our construction company. Budget around $50K. Let\'s schedule a call.', 'source_page' => '/enterprise', 'utm_source' => 'linkedin', 'utm_medium' => 'sponsored', 'status' => 'replied', 'created_at' => now()->subDays(4)],
        ];

        foreach ($submissions as $submission) {
            \App\Models\ContactSubmission::create($submission);
        }

        // ── Email Campaigns ──
        \App\Models\EmailCampaign::create([
            'name' => 'February Newsletter',
            'subject' => '🚀 New Features & Case Study — Seeda February Update',
            'body' => '<h2>Happy February!</h2><p>We\'re excited to share our latest updates:</p><ul><li>New AI-powered chatbot integration</li><li>Case study: How we helped FastLogistics save 40% on operations</li><li>Spring website redesign packages now available</li></ul><p>Reply to this email or <a href="https://seeda.dev/contact">contact us</a> for a free consultation!</p>',
            'status' => 'sent',
            'sent_at' => now()->subDays(3),
            'recipients_count' => 342,
            'opened_count' => 128,
            'clicked_count' => 45,
            'bounced_count' => 8,
            'unsubscribed_count' => 2,
        ]);

        \App\Models\EmailCampaign::create([
            'name' => 'Spring Promo 2026',
            'subject' => '🌸 Spring Sale: 20% Off Web Development',
            'body' => '<h2>Spring into a new website!</h2><p>For a limited time, get 20% off all web development projects started before April 1st.</p><p>Whether you need a brand new website, a redesign, or an e-commerce platform — we\'ve got you covered.</p><p><strong>Use code: SPRING2026</strong></p>',
            'status' => 'draft',
            'scheduled_at' => now()->addDays(5),
            'recipients_count' => 0,
            'opened_count' => 0,
            'clicked_count' => 0,
            'bounced_count' => 0,
            'unsubscribed_count' => 0,
        ]);

        // ── Social Media Posts ──
        $socialPosts = [
            ['title' => 'Case Study: FastLogistics', 'content' => '🚀 How we helped FastLogistics save 40% on operations with a custom logistics platform. Read the full case study on our website! #WebDev #CaseStudy #Logistics', 'platform' => 'linkedin', 'status' => 'published', 'published_at' => now()->subDays(5), 'likes' => 142, 'comments' => 23, 'shares' => 45, 'impressions' => 8500, 'clicks' => 320, 'campaign_id' => $campaign2->id, 'created_by' => $admin->id, 'hashtags' => ['WebDev', 'CaseStudy', 'Digital']],
            ['title' => 'Spring Sale Announcement', 'content' => '🌸 Spring is here and so are our deals! 20% off all web development projects started before April 1st. Use code SPRING2026 🌸', 'platform' => 'instagram', 'status' => 'published', 'published_at' => now()->subDays(3), 'likes' => 287, 'comments' => 41, 'shares' => 89, 'impressions' => 12400, 'clicks' => 560, 'campaign_id' => $campaign1->id, 'created_by' => $admin->id, 'hashtags' => ['SpringSale', 'WebDesign', 'Seeda']],
            ['title' => 'Behind the Scenes: AI Integration', 'content' => '🤖 A look behind the scenes at how we integrate AI chatbots into client websites. Thread 🧵👇', 'platform' => 'twitter', 'status' => 'published', 'published_at' => now()->subDays(1), 'likes' => 98, 'comments' => 15, 'shares' => 33, 'impressions' => 5200, 'clicks' => 180, 'created_by' => $admin->id, 'hashtags' => ['AI', 'Chatbot', 'WebDev']],
            ['title' => 'Client Testimonial Video', 'content' => 'Hear from our client Elena about how our custom CRM transformed her design studio.', 'platform' => 'youtube', 'status' => 'scheduled', 'scheduled_at' => now()->addDays(2), 'created_by' => $admin->id, 'hashtags' => ['Testimonial', 'Client']],
            ['title' => 'Quick Tip: SEO Basics', 'content' => '📈 5 quick SEO tips for small businesses:\n1. Optimize title tags\n2. Use alt text on images\n3. Improve page speed\n4. Get quality backlinks\n5. Create valuable content', 'platform' => 'facebook', 'status' => 'draft', 'created_by' => $admin->id, 'hashtags' => ['SEO', 'Tips', 'SmallBusiness']],
            ['title' => 'Team Growth Update', 'content' => '🎉 We\'re growing! 3 new developers joined the Seeda team this month. Exciting projects ahead! #Hiring #TechTeam', 'platform' => 'linkedin', 'status' => 'published', 'published_at' => now()->subWeek(), 'likes' => 210, 'comments' => 35, 'shares' => 52, 'impressions' => 9800, 'clicks' => 0, 'created_by' => $admin->id, 'hashtags' => ['Hiring', 'Growth', 'TechTeam']],
        ];

        foreach ($socialPosts as $post) {
            \App\Models\SocialMediaPost::create($post);
        }

        // ── SEO Keywords ──
        $seoKeywords = [
            ['keyword' => 'web development agency', 'target_page' => 'https://seeda.dev', 'current_position' => 8, 'previous_position' => 12, 'best_position' => 6, 'search_volume' => 2400, 'difficulty' => 65, 'cpc' => 4.50, 'status' => 'tracking', 'campaign_id' => $campaign3->id],
            ['keyword' => 'custom software development', 'target_page' => 'https://seeda.dev/services', 'current_position' => 15, 'previous_position' => 18, 'best_position' => 12, 'search_volume' => 1900, 'difficulty' => 72, 'cpc' => 6.20, 'status' => 'tracking', 'campaign_id' => $campaign3->id],
            ['keyword' => 'laravel development company', 'target_page' => 'https://seeda.dev/services/web', 'current_position' => 4, 'previous_position' => 5, 'best_position' => 3, 'search_volume' => 880, 'difficulty' => 45, 'cpc' => 3.80, 'status' => 'tracking', 'campaign_id' => $campaign3->id],
            ['keyword' => 'ecommerce website development', 'target_page' => 'https://seeda.dev/services/ecommerce', 'current_position' => 22, 'previous_position' => 19, 'best_position' => 15, 'search_volume' => 3200, 'difficulty' => 78, 'cpc' => 5.90, 'status' => 'tracking'],
            ['keyword' => 'mobile app development italy', 'target_page' => 'https://seeda.dev/services/mobile', 'current_position' => 6, 'previous_position' => 9, 'best_position' => 5, 'search_volume' => 720, 'difficulty' => 38, 'cpc' => 3.20, 'status' => 'tracking'],
            ['keyword' => 'CRM development services', 'target_page' => 'https://seeda.dev/services/crm', 'current_position' => 11, 'previous_position' => 14, 'best_position' => 11, 'search_volume' => 1100, 'difficulty' => 55, 'cpc' => 4.10, 'status' => 'tracking'],
            ['keyword' => 'website redesign cost', 'target_page' => 'https://seeda.dev/pricing', 'current_position' => 31, 'previous_position' => 28, 'best_position' => 20, 'search_volume' => 4500, 'difficulty' => 82, 'cpc' => 7.40, 'status' => 'tracking'],
            ['keyword' => 'best web agency europe', 'target_page' => 'https://seeda.dev', 'current_position' => null, 'previous_position' => null, 'best_position' => null, 'search_volume' => 590, 'difficulty' => 90, 'cpc' => 8.50, 'status' => 'tracking'],
        ];

        foreach ($seoKeywords as $kw) {
            \App\Models\SeoKeyword::create($kw);
        }

        // ── Lead Activities ──
        $firstLead = \App\Models\Lead::first();
        if ($firstLead) {
            $activities = [
                ['lead_id' => $firstLead->id, 'user_id' => $admin->id, 'type' => 'note', 'description' => 'Initial contact via Google Ads landing page. Interested in full website redesign.', 'created_at' => now()->subDays(10)],
                ['lead_id' => $firstLead->id, 'user_id' => $admin->id, 'type' => 'call', 'description' => 'Discovery call — discussed requirements, budget ~€8.5K, timeline Q1 2026.', 'metadata' => ['duration' => '25 min', 'outcome' => 'positive'], 'created_at' => now()->subDays(7)],
                ['lead_id' => $firstLead->id, 'user_id' => $admin->id, 'type' => 'email', 'description' => 'Sent project brief and preliminary scope document.', 'created_at' => now()->subDays(5)],
                ['lead_id' => $firstLead->id, 'user_id' => $admin->id, 'type' => 'proposal', 'description' => 'Sent formal proposal — Website redesign + CMS, €8,500.', 'created_at' => now()->subDays(3)],
                ['lead_id' => $firstLead->id, 'user_id' => $admin->id, 'type' => 'follow_up', 'description' => 'Follow up on proposal — waiting for client review.', 'scheduled_at' => now()->addDays(2), 'is_completed' => false, 'created_at' => now()->subDay()],
            ];

            foreach ($activities as $activity) {
                \App\Models\LeadActivity::create($activity);
            }
        }

        // ── Partners (Affiliates) ──
        $partner1 = \App\Models\Partner::create([
            'name' => 'Digital Growth Agency',
            'email' => 'partners@digitalgrowth.com',
            'code' => 'DGA2024',
            'commission_rate' => 15.00,
            'type' => 'agency',
            'status' => 'active',
            'balance' => 1250.00,
            'total_earned' => 4500.00,
        ]);

        $partner2 = \App\Models\Partner::create([
            'name' => 'Marco Rossi (Consultant)',
            'email' => 'marco.consultant@gmail.com',
            'code' => 'MARCO5',
            'commission_rate' => 10.00,
            'type' => 'individual',
            'status' => 'active',
            'balance' => 0,
            'total_earned' => 850.00,
        ]);

        // ── Marketing Funnels ──
        $funnel1 = \App\Models\MarketingFunnel::create([
            'name' => '2024 Custom Software Price Guide',
            'slug' => 'pricing-guide-2024',
            'type' => 'price_guide',
            'file_path' => 'funnels/pricing-guide.pdf',
            'is_locked' => true,
            'conversions' => 45,
        ]);

        $funnel2 = \App\Models\MarketingFunnel::create([
            'name' => 'AI Transformation in Fintech',
            'slug' => 'fintech-ai-case-study',
            'type' => 'case_study',
            'file_path' => 'funnels/fintech-ai.pdf',
            'is_locked' => true,
            'conversions' => 28,
        ]);

        // ── Referrals ──
        $leads = \App\Models\Lead::limit(3)->get();
        if ($leads->count() >= 2) {
            \App\Models\Referral::create([
                'partner_id' => $partner1->id,
                'lead_id' => $leads[0]->id,
                'status' => 'converted',
                'payout_amount' => 500.00,
                'is_recurring' => true,
            ]);

            \App\Models\Referral::create([
                'partner_id' => $partner2->id,
                'lead_id' => $leads[1]->id,
                'status' => 'pending',
                'payout_amount' => 0,
            ]);
        }

        // ── Behavioral Interactions (Lead Scoring) ──
        if ($firstLead) {
            $interactions = [
                ['action' => 'view_pricing', 'points' => 20, 'url' => 'https://seeda.dev/pricing'],
                ['action' => 'download_case_study', 'points' => 30, 'url' => 'https://seeda.dev/l/fintech-ai-case-study'],
                ['action' => 'view_services', 'points' => 10, 'url' => 'https://seeda.dev/services'],
            ];

            foreach ($interactions as $inter) {
                \App\Models\LeadInteraction::create(array_merge($inter, [
                    'lead_id' => $firstLead->id,
                    'session_id' => 'seed-session-123',
                ]));
            }

            // Update the lead score based on these interactions
            $firstLead->increment('score', 60);
            $firstLead->update(['priority' => 'high']);
        }

        // ── Email Templates ──
        $template1 = \App\Models\EmailTemplate::create([
            'name' => 'Initial Welcome Email',
            'subject' => 'Welcome to Seeda, {{name}}! 🚀',
            'content' => '<h1>Hi {{name}},</h1><p>Thanks for your interest in Seeda. We help companies like <strong>{{company}}</strong> scale with custom software.</p><p>Would you like to schedule a quick discovery call?</p><p>Best,<br>The Seeda Team</p>',
            'category' => 'marketing',
        ]);

        $template2 = \App\Models\EmailTemplate::create([
            'name' => 'Follow-up After Demo',
            'subject' => 'Next steps for {{company}}',
            'content' => '<h1>Hi {{name}},</h1><p>Great speaking with you today. As discussed, here is the modified proposal for {{company}}.</p><p>Let me know if you have any questions.</p>',
            'category' => 'sales',
        ]);

        // ── Email Lists ──
        $list1 = \App\Models\EmailList::create([
            'name' => 'Tech Founders 2024',
            'description' => 'Leads specifically from the tech sector',
            'color' => '#10B981',
        ]);

        $list2 = \App\Models\EmailList::create([
            'name' => 'Retargeting List',
            'description' => 'Users who downloaded the pricing guide',
            'color' => '#F59E0B',
        ]);

        // Add some subscribers to lists
        $subs = \App\Models\NewsletterSubscriber::limit(5)->get();
        foreach ($subs as $sub) {
            $list1->subscribers()->attach($sub->id);
        }
    }
}
