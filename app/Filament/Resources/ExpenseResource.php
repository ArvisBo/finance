<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('created_user_id')
                ->default(fn () => auth()->id()),
                Select::make('user_id')
                    ->default(fn () => auth()->id())
                    ->label('Author')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('category_id')
                    ->label('Category')
                    ->options(ExpenseCategory::all()->pluck('category_name', 'id'))
                    ->searchable(),
                TextInput::make('product_name'),
                TextInput::make('date'),
                TextInput::make('count')
                ->integer(),
                TextInput::make('price')
                ->numeric()
                ->inputMode('decimal'),
                TextInput::make('total_price'),
                FileUpload::make('receipt_image'),
                TextInput::make('additional_information'),
                TextInput::make('warranty_until'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User name'),
                TextColumn::make('expencecategory.category_name')->label('Category Name'),
                TextColumn::make('product_name'),
                TextColumn::make('date')->date(),
                TextColumn::make('count'),
                TextColumn::make('price'),
                TextColumn::make('total_price'),
                ImageColumn::make('receipt_image'),
                TextColumn::make('additional_information'),
                TextColumn::make('warranty_until')->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'view' => Pages\ViewExpense::route('/{record}'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
