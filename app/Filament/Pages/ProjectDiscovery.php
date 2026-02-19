<?php

namespace App\Filament\Pages;

use App\Models\ProjectOpportunity;
use Filament\Pages\Page;

class ProjectDiscovery extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = '🗺️ Project Discovery';
    protected static ?int $navigationSort = 17;
    protected static string $view = 'filament.pages.project-discovery';

    public function getStats(): array
    {
        return [
            'total' => ProjectOpportunity::count(),
            'active' => ProjectOpportunity::active()->count(),
            'applied' => ProjectOpportunity::where('status', 'applied')->count(),
            'interviewing' => ProjectOpportunity::where('status', 'interviewing')->count(),
            'won' => ProjectOpportunity::where('status', 'won')->count(),
            'lost' => ProjectOpportunity::where('status', 'lost')->count(),
            'win_rate' => ProjectOpportunity::whereIn('status', ['won', 'lost'])->count() > 0
                ? round(ProjectOpportunity::won()->count() / ProjectOpportunity::whereIn('status', ['won', 'lost'])->count() * 100, 1)
                : 0,
            'total_won_value' => (float) ProjectOpportunity::won()->sum('budget_max'),
        ];
    }

    public function getSourceBreakdown(): array
    {
        return ProjectOpportunity::selectRaw('source, count(*) as total, SUM(CASE WHEN status = "won" THEN 1 ELSE 0 END) as won')
            ->groupBy('source')
            ->orderByDesc('total')
            ->get()
            ->map(fn($row) => [
                'source' => ProjectOpportunity::getSourceOptions()[$row->source] ?? $row->source,
                'key' => $row->source,
                'total' => $row->total,
                'won' => $row->won,
                'rate' => $row->total > 0 ? round(($row->won / $row->total) * 100) : 0,
            ])
            ->toArray();
    }

    public function getChannels(): array
    {
        return [
            [
                'name' => 'Upwork',
                'icon' => '🟢',
                'url' => 'https://www.upwork.com',
                'type' => 'Freelance Platform',
                'tips' => [
                    'Profile عالی بنویس با portfolio قوی',
                    'Proposal شخصی‌سازی شده بفرست، نه کپی',
                    'اول پروژه‌های کوچک بگیر برای review',
                    'Connects رو هوشمندانه خرج کن',
                    'Top Rated شدن اولویت اوله',
                ],
            ],
            [
                'name' => 'LinkedIn',
                'icon' => '🔗',
                'url' => 'https://www.linkedin.com',
                'type' => 'Professional Network',
                'tips' => [
                    'پست‌های فنی و Case Study بذار',
                    'با CTOها و Product Managerها ارتباط بگیر',
                    'توی گروه‌های فنی فعال باش',
                    'Open to Work رو روشن کن',
                    'هفته‌ای ۲-۳ پست ارزشمند بذار',
                ],
            ],
            [
                'name' => 'GitHub',
                'icon' => '🐙',
                'url' => 'https://github.com',
                'type' => 'Open Source',
                'tips' => [
                    'پروژه‌های Open Source بساز',
                    'توی پروژه‌های معروف Contribute کن',
                    'README حرفه‌ای بنویس',
                    'GitHub Sponsors رو فعال کن',
                    'Issue حل کن → مشتری جذب کن',
                ],
            ],
            [
                'name' => 'Toptal',
                'icon' => '🔷',
                'url' => 'https://www.toptal.com',
                'type' => 'Premium Freelance',
                'tips' => [
                    'فقط Top 3% قبول میشن',
                    'مصاحبه فنی خیلی سخته، آماده باش',
                    'Rate بالاتر از Upwork',
                    'پروژه‌های Enterprise میدن',
                    'باید ۲+ سال تجربه حرفه‌ای داشته باشی',
                ],
            ],
            [
                'name' => 'Clutch',
                'icon' => '⭐',
                'url' => 'https://clutch.co',
                'type' => 'B2B Reviews',
                'tips' => [
                    'Profile شرکتت رو بساز',
                    'از مشتری‌های قبلی review بخواه',
                    'Verified review خیلی ارزشمنده',
                    'Ranking بالا = لید بیشتر',
                    'Case Study با جزئیات بذار',
                ],
            ],
            [
                'name' => 'Referral / Network',
                'icon' => '🤝',
                'url' => null,
                'type' => 'Personal Network',
                'tips' => [
                    'بهترین و ارزان‌ترین منبع پروژه',
                    'از هر مشتری referral بخواه',
                    'Commission بده برای معرفی',
                    'توی Meetup و Conference شرکت کن',
                    'با آژانس‌های دیگه Partner شو',
                ],
            ],
            [
                'name' => 'Direct Outreach',
                'icon' => '📧',
                'url' => null,
                'type' => 'Cold Outreach',
                'tips' => [
                    'SaaS‌هایی که از تکنولوژی مشابه استفاده میکنن پیدا کن',
                    'Cold email شخصی‌سازی شده بزن',
                    'مشکل واقعی‌شون رو شناسایی کن',
                    'Free audit پیشنهاد بده',
                    'هفته‌ای ۲۰ ایمیل هدفمند بزن',
                ],
            ],
            [
                'name' => 'Content Marketing',
                'icon' => '✍️',
                'url' => null,
                'type' => 'Inbound',
                'tips' => [
                    'بلاگ فنی بنویس (SEO-friendly)',
                    'توی Dev.to و Medium مقاله بذار',
                    'YouTube Tutorial بساز',
                    'Case Study از پروژه‌های قبلی منتشر کن',
                    'Newsletter راه بنداز',
                ],
            ],
        ];
    }

    public function getWorkflow(): array
    {
        return [
            ['step' => 1, 'title' => 'کشف و جستجو', 'icon' => '🔍', 'desc' => 'پلتفرم‌ها رو چک کن، فیلترها رو تنظیم کن، پروژه‌های مناسب رو پیدا کن'],
            ['step' => 2, 'title' => 'ثبت فرصت', 'icon' => '📝', 'desc' => 'پروژه رو توی Project Finder ثبت کن با جزئیات کامل'],
            ['step' => 3, 'title' => 'Proposal بنویس', 'icon' => '📄', 'desc' => 'Proposal شخصی‌سازی شده بنویس، portfolio مرتبط اضافه کن'],
            ['step' => 4, 'title' => 'Apply / ارسال', 'icon' => '📨', 'desc' => 'Apply کن و استتوس رو به Applied تغییر بده'],
            ['step' => 5, 'title' => 'پیگیری', 'icon' => '🔔', 'desc' => 'بعد ۳-۵ روز Follow-up بزن اگه جواب ندادن'],
            ['step' => 6, 'title' => 'مصاحبه / مذاکره', 'icon' => '🎤', 'desc' => 'مصاحبه فنی، بررسی نیازها، مذاکره قیمت'],
            ['step' => 7, 'title' => 'برنده شدن! 🏆', 'icon' => '✅', 'desc' => 'قرارداد ببند، پروژه رو شروع کن، Lead رو تبدیل به Client کن'],
        ];
    }
}
