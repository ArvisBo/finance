<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use Filament\Widgets\ChartWidget;

class ExpenseCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Expenses by Category for the Month';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $expenses = Expense::whereMonth('expense_date', now()->month) // Atlasa tekošā mēneša izdevumus
            ->whereHas('expenseAccount', function ($query) {
                // atlasa tikai tos izdevumus, kur konta owner ir autorizētais lietotājs
                $query->where('account_owner_id', auth()->id());
            })
            ->with('expenseCategory') // ielādē izdevumu categorijas
            ->selectRaw('expense_category_id, SUM(total_price) as total') // sasummē visus kategorijas izdevumus
            ->groupBy('expense_category_id')
            ->get();

        if ($expenses->isEmpty()) {
            return [
                'labels' => ['No Data'],
                'datasets' => [
                    [
                        'label' => 'Expenses by category',
                        'data' => [0],
                        'backgroundColor' => ['rgba(54, 162, 235, 0.2)'],
                        'borderColor' => ['rgba(54, 162, 235, 1)'],
                        'borderWidth' => 1,
                    ],
                ],
            ];
        }

        $labels = $expenses->map(fn ($expense) => $expense->expenseCategory->expense_category_name ?? 'Unknown Category')->toArray();
        $totals = $expenses->pluck('total')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Expenses by category',
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
