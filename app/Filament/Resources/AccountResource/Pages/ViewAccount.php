<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewAccount extends ViewRecord
{
    protected static string $resource = AccountResource::class;

    public function form(Form $form): Form
    {
        return $form ->schema([
            Select::make('created_user_id')
                ->disabled()
                ->options(User::all()->mapWithKeys(function ($user) {
                    return [$user->id => $user->name . ' ' . $user->surname];
                })),
            Select::make('account_owner_id')
                ->disabled()
                ->options(User::all()->mapWithKeys(function ($user) {
                    return [$user->id => $user->name . ' ' . $user->surname];
                })),
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('account_number')
                ->required()
                ->maxLength(255),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
