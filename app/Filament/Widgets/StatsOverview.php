<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $userId = auth()->id();

        // Tekošā mēneša ienākumi un izdevumi
        $totalExpensesThisMonth = Expense::where('created_user_id', $userId)
            ->whereMonth('expense_date', now()->month)
            ->sum('total_price');

        $totalIncomesThisMonth = Income::where('created_user_id', $userId)
            ->whereMonth('income_date', now()->month)
            ->sum('amount');

        // Tekošā gada ienākumi un izdevumi
        $totalExpensesThisYear = Expense::where('created_user_id', $userId)
            ->whereYear('expense_date', now()->year)
            ->sum('total_price');

        $totalIncomesThisYear = Income::where('created_user_id', $userId)
            ->whereYear('income_date', now()->year)
            ->sum('amount');
        return [
            // Mēneša statu kartiņas
            Stat::make('Total Spent This Month', number_format($totalExpensesThisMonth, 2) . ' $')
                ->description('Expenses for the current month')
                ->descriptionColor('danger')
                ->color('danger')
                ->chart([3, 2, 7, 5, 8])
                ->chartColor('danger'),
            Stat::make('Total Income This Month', number_format($totalIncomesThisMonth, 2) . ' $')
                ->description('Incomes for the current month')
                ->descriptionColor('success')
                ->color('success')
                ->chart([1, 5, 3, 6, 9])
                ->chartColor('success'),

            // gada statu kartiņas
            Stat::make('Total Spent This Year', number_format($totalExpensesThisYear, 2) . ' $')
                ->description('Expenses for the current year')
                ->descriptionIcon('heroicon-c-arrow-trending-down')
                ->color('danger'),
            Stat::make('Total Income This Year', number_format($totalIncomesThisYear, 2) . ' $')
                ->description('Incomes for the current year')
                ->descriptionIcon('heroicon-c-arrow-trending-up')
                ->color('success'),
        ];
    }
}
