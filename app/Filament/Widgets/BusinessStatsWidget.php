<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Website;
use App\Models\Project;
use App\Models\Task;
use App\Models\TimeEntry;
use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BusinessStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = -2;

    protected function getStats(): array
    {
        $totalRevenue = Invoice::where('status', 'paid')->sum('total');
        $outstanding = Invoice::whereIn('status', ['sent', 'overdue'])->sum('total');
        $activeProjects = Project::active()->count();
        $openTasks = Task::whereIn('status', ['todo', 'in_progress'])->count();
        $hoursThisMonth = TimeEntry::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('hours');
        $openTickets = Ticket::open()->count();
        $activeClients = Client::where('is_active', true)->count();
        $activeWebsites = Website::where('status', 'active')->count();

        return [
            Stat::make('Revenue', '€' . number_format($totalRevenue, 0))
                ->description('€' . number_format($outstanding, 0) . ' outstanding')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Active Projects', $activeProjects)
                ->description($openTasks . ' open tasks')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('primary'),

            Stat::make('Hours This Month', number_format($hoursThisMonth, 1) . 'h')
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),

            Stat::make('Open Tickets', $openTickets)
                ->description($activeClients . ' clients, ' . $activeWebsites . ' websites')
                ->descriptionIcon('heroicon-m-ticket')
                ->color($openTickets > 5 ? 'danger' : 'warning'),
        ];
    }
}
