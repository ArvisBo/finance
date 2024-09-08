<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Filament\Resources\ExpenseResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListExpenses extends ListRecords
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'This Month' => Tab::make()
            ->modifyQueryUsing(fn(Builder $query) => $query->where('expense_date', '>=', now()->startOfMonth())),
            'Six Month' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('expense_date', '>=', now()->subMonth(6))),
            'Year' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('expense_date', '>=', now()->subYear())),
            'All'=>Tab::make()
        ];
    }
}
