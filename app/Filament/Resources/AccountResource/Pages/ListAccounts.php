<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAccounts extends ListRecords
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'My accounts' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('account_owner_id', auth()->id())),
            'Shared with me accounts' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->whereIn('id', function ($subQuery) {
                        $subQuery->select('account_id')
                             ->from('user_account_permissions')
                             ->where('user_id', auth()->id());
                });
            }),
                // ->modifyQueryUsing(fn(Builder $query) => $query->where()),
        ];
    }
}
