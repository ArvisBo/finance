<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Income; // Assuming you have an Income model
use Filament\Widgets\ChartWidget;

class YearlyExpenseIncomeChart extends ChartWidget
{
    protected static ?string $heading = 'Yearly Expenses and Incomes';

    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Get total expenses for each month of the current year
        $expenses = Expense::whereYear('expense_date', now()->year)
            ->whereHas('expenseAccount', function ($query) {
                // Only show expenses where the authenticated user owns the account
                $query->where('account_owner_id', auth()->id());
            })
            ->selectRaw('MONTH(expense_date) as month, SUM(total_price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get total incomes for each month of the current year
        $incomes = Income::whereYear('income_date', now()->year)
            ->whereHas('incomeAccount', function ($query) {
                // Only show incomes where the authenticated user owns the account
                $query->where('account_owner_id', auth()->id());
            })
            ->selectRaw('MONTH(income_date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare labels for each month
        $months = collect(range(1, 12))->map(fn($month) => date('F', mktime(0, 0, 0, $month, 1)));

        // Match each month with the expense and income data
        $expenseData = $months->map(fn($month) => $expenses->firstWhere('month', $months->search($month) + 1)->total ?? 0);
        $incomeData = $months->map(fn($month) => $incomes->firstWhere('month', $months->search($month) + 1)->total ?? 0);

        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'Total Expenses',
                    'data' => $expenseData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'fill' => false,
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Total Incomes',
                    'data' => $incomeData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'fill' => false,
                    'borderWidth' => 2,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
