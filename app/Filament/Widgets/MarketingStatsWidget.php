<?php

namespace App\Filament\Widgets;

use App\Models\Campaign;
use App\Models\ContactSubmission;
use App\Models\Lead;
use App\Models\NewsletterSubscriber;
use App\Models\SeoKeyword;
use App\Models\SocialMediaPost;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MarketingStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = -1;
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        // Leads
        $newLeads = Lead::thisMonth()->count();
        $openLeads = Lead::open()->count();
        $wonLeads = Lead::won()->thisMonth()->count();
        $pipelineValue = Lead::open()->sum('estimated_value');
        $hotLeads = Lead::where('score', '>=', 50)->open()->count();

        // Campaigns
        $activeCampaigns = Campaign::active()->count();
        $totalSpent = Campaign::active()->sum('spent');
        $totalRevenue = Campaign::active()->sum('revenue_generated');
        $totalClicks = Campaign::active()->sum('clicks');
        $totalConversions = Campaign::active()->sum('conversions');

        // Contact forms
        $unreadMessages = ContactSubmission::unread()->count();

        // Subscribers
        $totalSubscribers = NewsletterSubscriber::where('is_active', true)->count();

        // Conversion rate
        $totalLeads = Lead::count();
        $convertedLeads = Lead::won()->count();
        $conversionRate = $totalLeads > 0
            ? round(($convertedLeads / $totalLeads) * 100, 1)
            : 0;

        // Social media
        $publishedPosts = SocialMediaPost::published()->thisMonth()->count();
        $scheduledPosts = SocialMediaPost::scheduled()->count();
        $totalEngagement = SocialMediaPost::published()
            ->selectRaw('SUM(likes + comments + shares) as total')
            ->value('total') ?? 0;

        // SEO
        $trackingKeywords = SeoKeyword::tracking()->count();
        $top10Keywords = SeoKeyword::topRanking(10)->count();

        // Campaign ROI
        $avgRoi = $totalSpent > 0
            ? round((($totalRevenue - $totalSpent) / $totalSpent) * 100, 1)
            : 0;

        return [
            Stat::make('New Leads (This Month)', $newLeads)
                ->description($openLeads . ' in pipeline · ' . $hotLeads . ' 🔥 hot')
                ->color('success')
                ->icon('heroicon-o-user-plus'),

            Stat::make('Pipeline Value', '€' . number_format($pipelineValue, 0))
                ->description($wonLeads . ' won this month')
                ->color('info')
                ->icon('heroicon-o-currency-euro'),

            Stat::make('Conversion Rate', $conversionRate . '%')
                ->description($convertedLeads . '/' . $totalLeads . ' total leads')
                ->color($conversionRate > 20 ? 'success' : 'warning')
                ->icon('heroicon-o-arrow-trending-up'),

            Stat::make('Active Campaigns', $activeCampaigns)
                ->description('ROI: ' . $avgRoi . '% · ' . number_format($totalConversions) . ' conversions')
                ->color($avgRoi > 0 ? 'success' : 'danger')
                ->icon('heroicon-o-megaphone'),

            Stat::make('Social Media', $publishedPosts . ' posts')
                ->description($scheduledPosts . ' scheduled · ' . number_format($totalEngagement) . ' engagement')
                ->color('info')
                ->icon('heroicon-o-chat-bubble-bottom-center-text'),

            Stat::make('SEO Keywords', $trackingKeywords . ' tracking')
                ->description($top10Keywords . ' in top 10')
                ->color($top10Keywords > 0 ? 'success' : 'warning')
                ->icon('heroicon-o-magnifying-glass-circle'),

            Stat::make('Unread Messages', $unreadMessages)
                ->description($totalSubscribers . ' newsletter subscribers')
                ->color($unreadMessages > 0 ? 'danger' : 'success')
                ->icon('heroicon-o-inbox-arrow-down'),
        ];
    }
}
