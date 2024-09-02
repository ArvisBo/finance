<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use App\Models\Account;
use Filament\Actions;
use App\Models\User;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Validation\Rule;

class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;

    public function form(Form $form): Form
    {
        return $form ->schema([
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
                ->maxLength(255)
                // Nodrošina, ka account_number ir unikāli
                ->rule(function ($get) {
                    return Rule::unique(Account::class, 'account_number')->ignore($get('id'));
                }),
        ]);
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
