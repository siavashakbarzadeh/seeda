<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Fiorentina — Restaurant & Hospitality Platform',
                'slug' => 'fiorentina',
                'category' => 'Web App',
                'tags' => ['Laravel', 'Tailwind CSS', 'MySQL', 'Responsive'],
                'excerpt' => 'A modern restaurant website with online reservation system, dynamic menu management, and an elegant user experience designed to elevate the dining brand.',
                'challenge' => 'The restaurant needed a professional digital presence that could handle online reservations, showcase their menu dynamically, and reflect the premium quality of their brand.',
                'solution' => 'We built a fully custom Laravel-based website with an admin panel for menu and reservation management, responsive design for mobile diners, and SEO optimization for local search visibility.',
                'results' => ['Online reservations increased 60%', 'Mobile traffic up 45%', 'Google Maps visibility improved', 'Admin manages menu in real-time'],
                'color' => '#B91C1C',
                'client_name' => 'Fiorentina',
                'technologies' => ['laravel', 'php', 'tailwind', 'mysql'],
                'sort_order' => 1,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Marigo — Corporate Business Website',
                'slug' => 'marigo',
                'category' => 'Web App',
                'tags' => ['Laravel', 'Tailwind CSS', 'CMS', 'Responsive'],
                'excerpt' => 'A sleek corporate website with content management capabilities, service showcasing, and lead generation forms designed for professional B2B engagement.',
                'challenge' => 'The client needed a professional corporate website that would establish credibility, showcase their services, and generate qualified business leads.',
                'solution' => 'We designed and developed a modern corporate website with a custom CMS for content management, integrated contact forms with lead tracking, and optimized the site for search engines and conversions.',
                'results' => ['Professional online presence established', 'Lead generation forms integrated', 'SEO-optimized for key terms', 'Full CMS for self-management'],
                'color' => '#1D4ED8',
                'client_name' => 'Marigo',
                'technologies' => ['laravel', 'php', 'tailwind', 'mysql'],
                'sort_order' => 2,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Tabulas — Digital Platform',
                'slug' => 'tabulas',
                'category' => 'Web App',
                'tags' => ['Laravel', 'React', 'API', 'Dashboard'],
                'excerpt' => 'A full-featured digital platform with interactive dashboards, data management tools, and a modern user interface built for efficiency and scalability.',
                'challenge' => 'The business required a robust platform to manage complex data workflows, provide interactive analytics, and offer a seamless user experience across devices.',
                'solution' => 'We built a full-stack web application with a Laravel backend API, React frontend with interactive charts and tables, role-based access control, and automated reporting capabilities.',
                'results' => ['Centralized data management', 'Real-time interactive dashboards', 'Role-based user access', 'Automated report generation'],
                'color' => '#7C3AED',
                'client_name' => 'Tabulas',
                'technologies' => ['laravel', 'react', 'php', 'mysql', 'tailwind'],
                'sort_order' => 3,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Di Maria Avvocatura — Law Firm Management Suite',
                'slug' => 'di-maria-avvocatura',
                'category' => 'Enterprise',
                'tags' => ['Laravel', 'Filament', 'React', 'Cloud SQL'],
                'excerpt' => 'A comprehensive legal management system with case tracking, document management, hearing calendars, and client portal — built for a modern law practice.',
                'challenge' => 'The law firm was managing cases, documents, hearings, and client communications across multiple disconnected tools, leading to inefficiency and missed deadlines.',
                'solution' => 'We developed an integrated legal management suite with case lifecycle tracking, automated deadline reminders, secure document storage on Google Cloud, client self-service portal, and financial reporting for invoices and expenses.',
                'results' => ['All case data centralized in one system', 'Automated hearing deadline alerts', 'Secure cloud document storage', 'Client satisfaction improved 40%'],
                'color' => '#0F766E',
                'client_name' => 'Di Maria Avvocatura',
                'technologies' => ['laravel', 'react', 'php', 'mysql', 'gcp', 'tailwind'],
                'sort_order' => 4,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'ECF — Enterprise Corporate Finance',
                'slug' => 'ecf',
                'category' => 'Enterprise',
                'tags' => ['Laravel', 'React', 'Filament', 'Google Cloud'],
                'excerpt' => 'A full-stack enterprise management platform for corporate finance operations including employee management, document processing, payroll, and compliance tracking.',
                'challenge' => 'The company needed a unified platform to manage HR operations, financial documents, employee contracts, payroll processing, and regulatory compliance across multiple departments.',
                'solution' => 'We built a modular enterprise suite with dedicated modules for employee management (Anagrafica), case management (Pratiche), document handling (Documenti), and financial workflows — all integrated with Google Cloud SQL for secure, scalable data storage.',
                'results' => ['Unified management across departments', 'Paperless document workflows', 'Compliance tracking automated', 'Deployed on Google Cloud infrastructure'],
                'color' => '#EA580C',
                'client_name' => 'ECF',
                'technologies' => ['laravel', 'react', 'php', 'mysql', 'gcp', 'docker', 'tailwind'],
                'sort_order' => 5,
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($projects as $project) {
            CaseStudy::updateOrCreate(
                ['slug' => $project['slug']],
                $project
            );
        }
    }
}
