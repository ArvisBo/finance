<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListIncomes extends ListRecords
{
    protected static string $resource = IncomeResource::class;

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
            ->modifyQueryUsing(fn(Builder $query) => $query->where('income_date', '>=', now()->startOfMonth())),
            'Six Month' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('income_date', '>=', now()->subMonth(6))),
            'Year' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('income_date', '>=', now()->subYear())),
            'All'=>Tab::make()
        ];
    }
}
