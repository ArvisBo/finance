<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use App\Models\Account;
use App\Models\Permission;
use App\Models\Role;
use Filament\Actions;
use App\Models\User;
use App\Models\UserAccountPermission;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Validation\Rule;

class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

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
        // Inline form for UserAccountPermission
        Repeater::make('permissionsAccount')
        ->relationship('permissionsAccount') // Refers to the hasMany relationship in the Account model
        ->schema([
            Select::make('user_id')
                ->label('Share with user')
                ->relationship('user', 'name')
                ->options(User::all()->mapWithKeys(function ($user) {
                    return [$user->id => $user->name . ' ' . $user->surname];
                })),

            Select::make('permission_id')
                ->label('Shared user permission')
                ->relationship('permission', 'name'),
        ])
        ->label('Share account with:')
        ->columns(2),
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
