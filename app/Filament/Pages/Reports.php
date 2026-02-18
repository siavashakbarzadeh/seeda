<?php

namespace App\Filament\Pages;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\Expense;
use App\Models\Client;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Business';
    protected static ?string $navigationLabel = 'Reports';
    protected static ?int $navigationSort = 10;
    protected static string $view = 'filament.pages.reports';

    public string $period = 'this_month';

    public function getRevenueData(): array
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Invoice::where('status', 'paid')
                ->whereMonth('paid_at', $date->month)
                ->whereYear('paid_at', $date->year)
                ->sum('total');
            $months->push([
                'month' => $date->format('M'),
                'revenue' => (float) $revenue,
            ]);
        }
        return $months->toArray();
    }

    public function getProjectStats(): array
    {
        return [
            'total' => Project::count(),
            'active' => Project::active()->count(),
            'completed' => Project::where('status', 'completed')->count(),
            'overdue' => Project::where('deadline', '<', now())
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count(),
        ];
    }

    public function getTimeStats(): array
    {
        $thisMonth = TimeEntry::whereMonth('date', now()->month)
            ->whereYear('date', now()->year);

        return [
            'total_hours' => (float) $thisMonth->sum('hours'),
            'billable_hours' => (float) $thisMonth->where('is_billable', true)->sum('hours'),
            'billable_value' => (float) $thisMonth->where('is_billable', true)
                ->get()->sum(fn($e) => $e->hours * ($e->project?->hourly_rate ?? 0)),
        ];
    }

    public function getExpenseStats(): array
    {
        $thisMonth = Expense::whereMonth('date', now()->month)
            ->whereYear('date', now()->year);

        return [
            'total' => (float) $thisMonth->sum('amount'),
            'by_category' => $thisMonth->get()
                ->groupBy('category')
                ->map(fn($items) => $items->sum('amount'))
                ->sortDesc()
                ->take(5)
                ->toArray(),
        ];
    }

    public function getTopClients(): array
    {
        return Client::withSum(['invoices as total_revenue' => fn($q) => $q->where('status', 'paid')], 'total')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get()
            ->map(fn($c) => [
                'name' => $c->name,
                'revenue' => (float) ($c->total_revenue ?? 0),
            ])
            ->toArray();
    }
}
