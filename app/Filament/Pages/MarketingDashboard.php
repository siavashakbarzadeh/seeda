<?php

namespace App\Filament\Pages;

use App\Models\Campaign;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\ContactSubmission;
use App\Models\EmailCampaign;
use App\Models\SocialMediaPost;
use App\Models\MarketingFunnel;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MarketingDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 0;
    protected static string $view = 'filament.pages.marketing-dashboard';

    public function getLeadPipeline(): array
    {
        $statuses = ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'won', 'lost'];
        $pipeline = [];

        foreach ($statuses as $status) {
            $query = Lead::where('status', $status);
            $pipeline[] = [
                'status' => $status,
                'label' => Lead::getStatusOptions()[$status] ?? ucfirst($status),
                'count' => $query->count(),
                'value' => (float) Lead::where('status', $status)->sum('estimated_value'),
            ];
        }

        return $pipeline;
    }

    public function getConversionFunnel(): array
    {
        $totalLeads = Lead::count() ?: 1;
        $contacted = Lead::whereNotIn('status', ['new'])->count();
        $qualified = Lead::whereIn('status', ['qualified', 'proposal', 'negotiation', 'won'])->count();
        $proposal = Lead::whereIn('status', ['proposal', 'negotiation', 'won'])->count();
        $won = Lead::where('status', 'won')->count();

        return [
            ['label' => 'All Leads', 'count' => Lead::count(), 'pct' => 100],
            ['label' => 'Contacted', 'count' => $contacted, 'pct' => round(($contacted / $totalLeads) * 100)],
            ['label' => 'Qualified', 'count' => $qualified, 'pct' => round(($qualified / $totalLeads) * 100)],
            ['label' => 'Proposal', 'count' => $proposal, 'pct' => round(($proposal / $totalLeads) * 100)],
            ['label' => 'Won', 'count' => $won, 'pct' => round(($won / $totalLeads) * 100)],
        ];
    }

    public function getMonthlyTrends(): array
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $leadsCount = Lead::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)->count();
            $wonCount = Lead::where('status', 'won')
                ->whereMonth('converted_at', $date->month)
                ->whereYear('converted_at', $date->year)->count();
            $revenue = Campaign::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('revenue_generated');

            $months->push([
                'month' => $date->format('M'),
                'leads' => $leadsCount,
                'won' => $wonCount,
                'revenue' => (float) $revenue,
            ]);
        }
        return $months->toArray();
    }

    public function getTopCampaigns(): array
    {
        return Campaign::active()
            ->orderByDesc('revenue_generated')
            ->take(5)
            ->get()
            ->map(fn($c) => [
                'name' => $c->name,
                'type' => Campaign::getTypeOptions()[$c->type] ?? $c->type,
                'spent' => (float) $c->spent,
                'revenue' => (float) $c->revenue_generated,
                'roi' => $c->roi,
                'leads' => $c->leads()->count(),
            ])
            ->toArray();
    }

    public function getUpcomingFollowUps(): array
    {
        return LeadActivity::where('is_completed', false)
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->take(5)
            ->with(['lead', 'user'])
            ->get()
            ->map(fn($a) => [
                'lead_name' => $a->lead?->name ?? '—',
                'lead_id' => $a->lead_id,
                'type' => LeadActivity::getTypeOptions()[$a->type] ?? $a->type,
                'description' => $a->description,
                'scheduled_at' => $a->scheduled_at->format('M d, H:i'),
                'assigned_to' => $a->user?->name ?? '—',
            ])
            ->toArray();
    }

    public function getOverdueFollowUps(): int
    {
        return LeadActivity::where('is_completed', false)
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<', now())
            ->count();
    }

    public function getQuickStats(): array
    {
        return [
            'new_leads_today' => Lead::whereDate('created_at', today())->count(),
            'unread_submissions' => ContactSubmission::where('status', 'new')->count(),
            'scheduled_emails' => EmailCampaign::where('status', 'scheduled')->count(),
            'scheduled_posts' => SocialMediaPost::where('status', 'scheduled')->count(),
            'funnel_conversions' => MarketingFunnel::sum('conversions'),
        ];
    }
}
