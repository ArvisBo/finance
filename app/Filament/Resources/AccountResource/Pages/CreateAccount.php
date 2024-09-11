<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Form;

class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function form(Form $form): Form
    {
        return $form ->schema([
            Hidden::make('created_user_id')
                ->default(fn () => auth()->id()),
            Select::make('account_owner_id')
                ->default(fn () => auth()->id())
                ->disabled()
                ->dehydrated()
                ->options(User::all()->mapWithKeys(function ($user) {
                    return [$user->id => $user->name . ' ' . $user->surname];
                })),
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('account_number')
                ->unique()
                ->required()
                ->maxLength(255),
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
                // ->required(),

            Select::make('permission_id')
                ->label('Shared user permission')
                ->relationship('permission', 'name'),
                // ->required(),
        ])
        ->label('Share account with:')
        ->columns(2),
    ]);

    }
}
