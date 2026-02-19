<?php

namespace App\Filament\Pages;

use App\Models\Campaign;
use App\Models\Lead;
use App\Models\EmailCampaign;
use App\Models\SocialMediaPost;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MarketingReports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Reports';
    protected static ?int $navigationSort = 15;
    protected static string $view = 'filament.pages.marketing-reports';

    public function getCampaignComparison(): array
    {
        return Campaign::orderByDesc('revenue_generated')
            ->take(8)
            ->get()
            ->map(fn($c) => [
                'name' => $c->name,
                'budget' => (float) $c->budget,
                'spent' => (float) $c->spent,
                'revenue' => (float) $c->revenue_generated,
                'roi' => $c->roi,
                'clicks' => $c->clicks,
                'conversions' => $c->conversions,
            ])
            ->toArray();
    }

    public function getChannelAttribution(): array
    {
        $data = Lead::where('status', 'won')
            ->select('source', DB::raw('count(*) as total'), DB::raw('SUM(estimated_value) as revenue'))
            ->groupBy('source')
            ->orderByDesc('revenue')
            ->get();

        $sourceOptions = Lead::getSourceOptions();

        return $data->map(fn($row) => [
            'source' => $sourceOptions[$row->source] ?? $row->source,
            'count' => $row->total,
            'revenue' => (float) ($row->revenue ?? 0),
        ])->toArray();
    }

    public function getLeadConversionByMonth(): array
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $created = Lead::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)->count();
            $won = Lead::where('status', 'won')
                ->whereMonth('converted_at', $date->month)
                ->whereYear('converted_at', $date->year)->count();

            $months->push([
                'month' => $date->format('M Y'),
                'created' => $created,
                'won' => $won,
                'rate' => $created > 0 ? round(($won / $created) * 100, 1) : 0,
            ]);
        }
        return $months->toArray();
    }

    public function getEmailStats(): array
    {
        $sent = EmailCampaign::where('status', 'sent')->get();
        $totalSent = $sent->sum('recipients_count');
        $totalOpened = $sent->sum('opened_count');
        $totalClicked = $sent->sum('clicked_count');
        $totalBounced = $sent->sum('bounced_count');

        return [
            'campaigns_sent' => $sent->count(),
            'total_sent' => $totalSent,
            'avg_open_rate' => $totalSent > 0 ? round(($totalOpened / $totalSent) * 100, 1) : 0,
            'avg_click_rate' => $totalSent > 0 ? round(($totalClicked / $totalSent) * 100, 1) : 0,
            'avg_bounce_rate' => $totalSent > 0 ? round(($totalBounced / $totalSent) * 100, 1) : 0,
        ];
    }

    public function getSocialMediaStats(): array
    {
        $published = SocialMediaPost::where('status', 'published');

        return [
            'total_posts' => $published->count(),
            'total_likes' => $published->sum('likes'),
            'total_comments' => $published->sum('comments'),
            'total_shares' => $published->sum('shares'),
            'total_impressions' => $published->sum('impressions'),
            'engagement_rate' => $published->count() > 0
                ? round(($published->sum('likes') + $published->sum('comments') + $published->sum('shares')) / max($published->sum('impressions'), 1) * 100, 2)
                : 0,
        ];
    }
}
