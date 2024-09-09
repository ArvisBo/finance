<?php

namespace App\Filament\Resources;

use App\Models\Account;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AccountResource\Pages;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Expenses and Incomes';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        // This method can be left empty if you are defining forms separately in the Create and Edit pages
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(Account::visible()) // nodrošina, ka tiek rādīti tikai ielogotā lietotāja ieraksti expense modelī methode scopeVisible
            ->columns([
                TextColumn::make('accountOwner.name')
                    ->label('Account owner')
                    ->formatStateUsing(function ($record) {
                        return $record->accountOwner->name . ' ' . $record->accountOwner->surname;
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Account name')
                    ->searchable(),
                TextColumn::make('account_number')
                    ->searchable(),
                TextColumn::make('accountCreator.name')
                ->label('Account creator')
                ->formatStateUsing(function ($record) {
                    return $record->accountCreator->name . ' ' . $record->accountCreator->surname;
                })
                ->sortable()
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'view' => Pages\ViewAccount::route('/{record}'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
