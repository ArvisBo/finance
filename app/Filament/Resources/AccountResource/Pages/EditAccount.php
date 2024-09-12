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
                ->unique(ignoreRecord: true),
        // Inline form for UserAccountPermission
        Repeater::make('userPermissionsToAccount')
        ->relationship('userPermissionsToAccount') // Relationship no Account modeļa
        ->schema([
            Select::make('user_id')
                ->label('Share with user')
                //jānomaina, lai nevar uzstādīt to pašu lietotāju, kas ir konta owners
                ->options(User::where('id', '!=', $this->record->account_owner_id)->get()->mapWithKeys(function ($user) {
                    return [$user->id => $user->name . ' ' . $user->surname];
                })),

            Select::make('permission_id')
                ->label('Shared user permission')
                ->relationship('permission', 'name'), // Relationship no UserAccountPermission modeļa
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
