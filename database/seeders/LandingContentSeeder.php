<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\LandingSection;
use Illuminate\Database\Seeder;

class LandingContentSeeder extends Seeder
{
    public function run(): void
    {
        // ── Landing Sections ──────────────────────────────────────
        $sections = [
            [
                'key' => 'hero',
                'title' => ['en' => 'We Build Digital Solutions That Drive Growth', 'it' => 'Costruiamo Soluzioni Digitali Che Guidano la Crescita', 'fa' => 'ما راه‌حل‌های دیجیتال می‌سازیم که رشد را هدایت می‌کنند'],
                'subtitle' => ['en' => 'From concept to launch, we create stunning websites and applications that convert visitors into customers.', 'it' => 'Dal concept al lancio, creiamo siti web e applicazioni straordinarie che convertono i visitatori in clienti.', 'fa' => 'از مفهوم تا راه‌اندازی، ما وب‌سایت‌ها و اپلیکیشن‌های خیره‌کننده‌ای می‌سازیم که بازدیدکنندگان را به مشتری تبدیل می‌کنند.'],
                'button_text' => ['en' => 'Start Your Project', 'it' => 'Inizia il Tuo Progetto', 'fa' => 'پروژه خود را شروع کنید'],
                'button_link' => '#contact',
                'sort_order' => 1,
            ],
            [
                'key' => 'services_intro',
                'title' => ['en' => 'Our Services', 'it' => 'I Nostri Servizi', 'fa' => 'خدمات ما'],
                'subtitle' => ['en' => 'Comprehensive digital solutions tailored to your business needs', 'it' => 'Soluzioni digitali complete su misura per le esigenze aziendali', 'fa' => 'راه‌حل‌های دیجیتال جامع متناسب با نیازهای کسب‌وکار شما'],
                'sort_order' => 2,
            ],
            [
                'key' => 'portfolio_intro',
                'title' => ['en' => 'Our Portfolio', 'it' => 'Il Nostro Portfolio', 'fa' => 'نمونه کارهای ما'],
                'subtitle' => ['en' => 'See how we\'ve helped businesses transform their digital presence', 'it' => 'Scopri come abbiamo aiutato le aziende a trasformare la loro presenza digitale', 'fa' => 'ببینید چگونه به کسب‌وکارها کمک کرده‌ایم حضور دیجیتال خود را متحول کنند'],
                'sort_order' => 3,
            ],
            [
                'key' => 'courses_intro',
                'title' => ['en' => 'Academy & Courses', 'it' => 'Academy & Corsi', 'fa' => 'آکادمی و دوره‌ها'],
                'subtitle' => ['en' => 'Level up your skills with our professional training programs', 'it' => 'Migliora le tue competenze con i nostri programmi di formazione professionale', 'fa' => 'مهارت‌های خود را با برنامه‌های آموزشی حرفه‌ای ما ارتقا دهید'],
                'sort_order' => 4,
            ],
            [
                'key' => 'testimonials_intro',
                'title' => ['en' => 'What Our Clients Say', 'it' => 'Cosa Dicono i Nostri Clienti', 'fa' => 'مشتریان ما چه می‌گویند'],
                'subtitle' => ['en' => 'Trusted by businesses worldwide', 'it' => 'Fidati dalle aziende di tutto il mondo', 'fa' => 'مورد اعتماد کسب‌وکارها در سراسر جهان'],
                'sort_order' => 5,
            ],
            [
                'key' => 'cta',
                'title' => ['en' => 'Ready to Start Your Project?', 'it' => 'Pronto per Iniziare il Tuo Progetto?', 'fa' => 'آماده شروع پروژه خود هستید؟'],
                'subtitle' => ['en' => 'Let\'s discuss how we can help you achieve your digital goals.', 'it' => 'Discutiamo di come possiamo aiutarti a raggiungere i tuoi obiettivi digitali.', 'fa' => 'بیایید درباره اینکه چگونه می‌توانیم به شما در دستیابی به اهداف دیجیتالتان کمک کنیم صحبت کنیم.'],
                'button_text' => ['en' => 'Contact Us', 'it' => 'Contattaci', 'fa' => 'تماس با ما'],
                'button_link' => '#contact',
                'sort_order' => 6,
            ],
        ];

        foreach ($sections as $section) {
            LandingSection::updateOrCreate(
                ['key' => $section['key']],
                $section
            );
        }

        // ── Courses ──────────────────────────────────────────────
        Course::updateOrCreate(
            ['slug' => 'academy-backend-laravel'],
            [
                'title' => [
                    'en' => 'Master Backend Laravel Developer',
                    'it' => 'Master Backend Laravel Dev – Seeda – Roma, Italy (Full Remote)',
                    'fa' => 'دوره مستر توسعه‌دهنده بک‌اند لاراول',
                ],
                'subtitle' => [
                    'en' => 'Learn to build enterprise applications with Laravel and AI',
                    'it' => 'Impara a sviluppare applicazioni enterprise con Laravel e AI',
                    'fa' => 'یادگیری ساخت اپلیکیشن‌های سازمانی با لاراول و هوش مصنوعی',
                ],
                'description' => [
                    'en' => 'With the Seeda Academy Master in Backend Laravel Development with AI Integration, students will learn to work in Agile methodology and develop end-to-end web applications in PHP/Laravel in enterprise contexts, using AI and Security tools. Our tutors, developers and industry professionals, follow students with one-to-one sessions throughout the course, supporting them in developing real projects and creating a professional portfolio.',
                    'it' => 'Con il Master in sviluppo Backend Laravel con integrazione dell\'AI di Seeda Academy, gli studenti impareranno a lavorare in metodologia Agile e a sviluppare applicazioni web end-to-end in PHP/Laravel in contesti enterprise, utilizzando strumenti di AI e Security. I nostri tutor, sviluppatori e professionisti del settore, seguono gli studenti con sessioni one-to-one per tutta la durata del corso, supportandoli nello sviluppo di progetti reali e nella creazione di un portfolio professionale.',
                    'fa' => 'با دوره مستر توسعه بک‌اند لاراول با یکپارچه‌سازی هوش مصنوعی آکادمی سیدا، دانشجویان یاد می‌گیرند در متدولوژی اجایل کار کرده و اپلیکیشن‌های وب end-to-end را در PHP/Laravel در محیط‌های سازمانی توسعه دهند. مدرسان ما، توسعه‌دهندگان و متخصصان صنعت، دانشجویان را با جلسات خصوصی در طول دوره همراهی می‌کنند.',
                ],
                'curriculum' => [
                    'en' => '<ul><li>Advanced Laravel Development (REST API, Authentication & Authorization, Testing, Queue & Jobs)</li><li>Integration with external services and cloud</li><li>Software Architecture and DevOps best practices (Git, CI/CD, Docker)</li><li>AI tools for development optimization</li></ul>',
                    'it' => '<ul><li>Sviluppo avanzato in Laravel (API REST, autenticazione e autorizzazione, testing, queue & jobs)</li><li>Integrazione con servizi esterni e cloud</li><li>Best practice di architettura software e DevOps (Git, CI/CD, Docker)</li><li>Utilizzo dell\'AI per ottimizzare il processo di sviluppo</li></ul>',
                    'fa' => '<ul><li>توسعه پیشرفته لاراول (API REST، احراز هویت و مجوزدهی، تست، صف و جاب‌ها)</li><li>یکپارچه‌سازی با سرویس‌های خارجی و ابری</li><li>بهترین شیوه‌های معماری نرم‌افزار و DevOps (Git, CI/CD, Docker)</li><li>استفاده از ابزارهای هوش مصنوعی برای بهینه‌سازی فرآیند توسعه</li></ul>',
                ],
                'career_info' => [
                    'en' => 'Thanks to our career service, at the end of the course students will be supported in entering the job market as Backend Laravel Developer, with full remote opportunities based in Rome and open to international collaborations.',
                    'it' => 'Grazie al nostro career service, al termine del corso gli studenti verranno accompagnati nell\'inserimento nel mondo del lavoro come Backend Laravel Developer, con opportunità full remote basate a Roma e aperte anche a collaborazioni internazionali.',
                    'fa' => 'به لطف سرویس کاریابی ما، در پایان دوره دانشجویان در ورود به بازار کار به عنوان توسعه‌دهنده بک‌اند لاراول حمایت می‌شوند، با فرصت‌های کار ریموت مستقر در رم و باز برای همکاری‌های بین‌المللی.',
                ],
                'price' => 2200.00,
                'currency' => 'EUR',
                'installment_info' => '6 months at 0%',
                'duration' => '3 months',
                'level' => 'intermediate',
                'format' => 'remote',
                'location' => 'Roma, Italy',
                'link' => 'https://seeda.uk/courses/academy-backend-laravel',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ]
        );
    }
}
