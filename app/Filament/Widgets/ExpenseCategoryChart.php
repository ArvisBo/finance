<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use Filament\Widgets\ChartWidget;

class ExpenseCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Expenses by Category for the Month';

    protected function getData(): array
    {
        $expenses = Expense::whereMonth('expense_date', now()->month) // Get expenses for the current month
            ->whereHas('expenseAccount', function ($query) {
                // Filter expenses where the account owner is the authenticated user
                $query->where('account_owner_id', auth()->id());
            })
            ->with('expenseCategory') // Load the related expense category
            ->selectRaw('expense_category_id, SUM(total_price) as total')
            ->groupBy('expense_category_id')
            ->get();

        if ($expenses->isEmpty()) {
            return [
                'labels' => ['No Data'],
                'datasets' => [
                    [
                        'label' => 'Expenses',
                        'data' => [0],
                        'backgroundColor' => ['rgba(54, 162, 235, 0.2)'],
                        'borderColor' => ['rgba(54, 162, 235, 1)'],
                        'borderWidth' => 1,
                    ],
                ],
            ];
        }

        // Extract category names and totals for the chart
        $labels = $expenses->map(fn ($expense) => $expense->expenseCategory->expense_category_name ?? 'Unknown Category')->toArray();
        $totals = $expenses->pluck('total')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Expenses',
                    'data' => $totals,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
