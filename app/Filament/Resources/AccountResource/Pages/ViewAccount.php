<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Repeater;
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
            ->label('Account shared with:')
            ->columns(2),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
