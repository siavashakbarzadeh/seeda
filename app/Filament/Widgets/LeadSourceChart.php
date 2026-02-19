<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class LeadSourceChart extends ChartWidget
{
    protected static ?string $heading = 'Leads by Source';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Lead::select('source', DB::raw('count(*) as total'))
            ->groupBy('source')
            ->pluck('total', 'source')
            ->toArray();

        $sourceOptions = Lead::getSourceOptions();
        $labels = [];
        $values = [];

        foreach ($data as $source => $count) {
            $labels[] = $sourceOptions[$source] ?? $source;
            $values[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Leads',
                    'data' => $values,
                    'backgroundColor' => [
                        '#36A2EB',
                        '#FF6384',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#C9CBCF'
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
