<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class TransactionChart extends ChartWidget
{
    protected static ?string $heading = 'Data Transaction (current month)';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Trend::query(Transaction::where('status', 'confirmed'))
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();
        return [
            'labels' => $data->map(fn ($item) => $item->date),
            'datasets' => [
                [
                    'label' => 'Confirmed Transaction',
                    'data' => $data->map(fn ($item) => $item->aggregate),
                    'backgroundColor' => '#4CAF50',
                    'borderColor' => '#4CAF50',
                    'fill' => false,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
