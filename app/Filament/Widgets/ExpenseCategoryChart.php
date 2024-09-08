<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpenseCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Expenses by Category for the Month';

    protected function getData(): array
    {
        // atlas sākuma un beigu datumu grafikiem
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // atlasa visus izdevumu konkrētajai kategorijai tekošajā mēnesī
        $expensesByCategory = DB::table('expenses')
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->select('expense_categories.expense_category_name as category', DB::raw('SUM(expenses.total_price) as total'))
            ->whereBetween('expenses.expense_date', [$startDate, $endDate])
            ->groupBy('expense_categories.expense_category_name')
            ->orderBy('total', 'desc')
            ->pluck('total', 'category');

        // sagatavo datu grafikam
        $categories = $expensesByCategory->keys()->toArray();
        $totals = $expensesByCategory->values()->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Expenses by Category',
                    'data' => $totals,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $categories,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; 
    }
}
