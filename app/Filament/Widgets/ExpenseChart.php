<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpenseChart extends ChartWidget
{
    protected static ?string $heading = 'Expenses for the Month';

    protected function getData(): array
    {
        // atlas sākuma un beigu datumu grafikiem
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // atlasa kopējos izdevumu dienā tekošajam mēnesim
        $expenses = DB::table('expenses')
            ->select(DB::raw('DATE(expense_date) as date'), DB::raw('SUM(total_price) as total'))
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // sagatavo datu grafikam
        $dates = [];
        $totals = [];

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $formattedDate = $currentDate->format('Y-m-d');
            $dates[] = $formattedDate;
            $totals[] = $expenses->get($formattedDate, 0); // jau kādā dienā nav izdevumu, tad uzstāda tai dienai 0
            $currentDate->addDay();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Daily Expenses',
                    'data' => $totals,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
