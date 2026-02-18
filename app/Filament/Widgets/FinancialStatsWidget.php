<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinancialStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = -2;
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $thisMonth = now()->month;
        $thisYear = now()->year;

        // Revenue this month
        $revenueThisMonth = Invoice::whereYear('issue_date', $thisYear)
            ->whereMonth('issue_date', $thisMonth)
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        // Revenue last month
        $lastMonth = now()->subMonth();
        $revenueLastMonth = Invoice::whereYear('issue_date', $lastMonth->year)
            ->whereMonth('issue_date', $lastMonth->month)
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        // Collected this month
        $collectedThisMonth = Payment::whereYear('payment_date', $thisYear)
            ->whereMonth('payment_date', $thisMonth)
            ->sum('amount');

        // Outstanding balance
        $outstandingBalance = Invoice::whereNotIn('status', ['paid', 'cancelled', 'draft'])
            ->sum('balance_due');

        // Overdue amount
        $overdueAmount = Invoice::overdue()->sum('balance_due');
        $overdueCount = Invoice::overdue()->count();

        // Expenses this month
        $expensesThisMonth = Expense::whereYear('date', $thisYear)
            ->whereMonth('date', $thisMonth)
            ->where('status', '!=', 'rejected')
            ->sum('amount');

        // YTD
        $revenueYTD = Invoice::thisYear()
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        $expensesYTD = Expense::whereYear('date', $thisYear)
            ->where('status', '!=', 'rejected')
            ->sum('amount');

        $profitYTD = $revenueYTD - $expensesYTD;

        // Trend
        $revenueDiff = $revenueThisMonth - $revenueLastMonth;
        $revenueDescription = $revenueDiff >= 0
            ? '↑ €' . number_format(abs($revenueDiff), 0) . ' vs last month'
            : '↓ €' . number_format(abs($revenueDiff), 0) . ' vs last month';

        return [
            Stat::make('Revenue (This Month)', '€' . number_format($revenueThisMonth, 0))
                ->description($revenueDescription)
                ->color($revenueDiff >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Collected (This Month)', '€' . number_format($collectedThisMonth, 0))
                ->description('Actual payments received')
                ->color('success')
                ->icon('heroicon-o-credit-card'),

            Stat::make('Outstanding', '€' . number_format($outstandingBalance, 0))
                ->description(
                    $overdueCount > 0
                    ? "⚠️ {$overdueCount} overdue (€" . number_format($overdueAmount, 0) . ")"
                    : 'All invoices on track'
                )
                ->color($overdueCount > 0 ? 'danger' : 'info')
                ->icon('heroicon-o-clock'),

            Stat::make('Expenses (This Month)', '€' . number_format($expensesThisMonth, 0))
                ->description('Profit: €' . number_format($revenueThisMonth - $expensesThisMonth, 0))
                ->color('warning')
                ->icon('heroicon-o-arrow-trending-down'),

            Stat::make('YTD Revenue', '€' . number_format($revenueYTD, 0))
                ->description('YTD Profit: €' . number_format($profitYTD, 0))
                ->color($profitYTD >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-chart-bar'),
        ];
    }
}
