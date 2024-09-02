<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Account;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function form(Form $form): Form
    {
        return $form ->schema([
            TextInput::make('name')
            ->required()
            ->maxLength(255),
        TextInput::make('surname')
            ->required()
            ->maxLength(255),
        TextInput::make('email')
            ->email()
            ->required()
            ->maxLength(255),
        DateTimePicker::make('email_verified_at'),
        TextInput::make('password')
            ->password()
            ->required()
            ->maxLength(255),
        Toggle::make('is_admin')
            ->required(),
        Select::make('default_account_id')
            ->options(Account::all()->pluck('name', 'id'))
            ->searchable(),
        ]);
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
