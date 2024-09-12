<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpenseChart extends ChartWidget
{
    protected static ?string $heading = 'Expenses for the Month';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $expenses = Expense::whereMonth('expense_date', now()->month) // Atlasa tekošā mēneša izdevumus
            ->whereHas('expenseAccount', function ($query) {
                // atlasa tikai tos izdevumus, kur konta owner ir autorizētais lietotājs
                $query->where('account_owner_id', auth()->id());
            })
            ->selectRaw('DAY(expense_date) as day, SUM(total_price) as total') //sasumē visus dienas izdevumus
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $days = $expenses->pluck('day')->toArray();
        $totals = $expenses->pluck('total')->toArray();

        return [
            'labels' => $days,
            'datasets' => [
                [
                    'label' => 'Total Expenses in days',
                    'data' => $totals,
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
