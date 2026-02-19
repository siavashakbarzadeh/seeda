<?php

namespace App\Filament\Widgets;

use App\Models\Campaign;
use Filament\Widgets\ChartWidget;

class CampaignPerformanceChart extends ChartWidget
{
    protected static ?string $heading = 'Campaign ROI (%)';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $campaigns = Campaign::active()->get();

        return [
            'datasets' => [
                [
                    'label' => 'ROI %',
                    'data' => $campaigns->pluck('roi')->toArray(),
                    'borderColor' => '#10B981',
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                ],
            ],
            'labels' => $campaigns->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
