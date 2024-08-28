<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeResource\Pages;
use App\Filament\Resources\IncomeResource\RelationManagers;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationLabel = 'Incomes';

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
                    ->searchable()
                    ->native(false),
                Select::make('category_id')
                    ->label('Category')
                    ->required()
                    ->options(IncomeCategory::all()->pluck('category_name', 'id'))
                    ->searchable()
                    ->native(false),
                DatePicker::make('date')
                    ->required()
                    ->format('Y-m-d'),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->inputMode('decimal'),
                TextInput::make('additional_information'),
            ])
            ->model(Income::where('user_id', auth()->id())->firstOrFail());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Income::visible()) // nodrošina, ka tiek rādīti tikai ielogotā lietotāja ieraksti
            ->columns([
                TextColumn::make('user.name')
                    ->label('User name'),
                TextColumn::make('incomecategory.category_name')
                    ->label('Category Name'),
                TextColumn::make('date')
                    ->date('Y-m-d'),
                TextColumn::make('amount'),
                TextColumn::make('additional_information'),
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

    // nodrošina, ka virs tabulas rādās lietotāja, kas ir ielogojies vārds
    public static function getLabel(): string
    {
        $user = Auth::user();
        return 'Incomes for ' . ($user ? $user->name : 'Guest');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncome::route('/create'),
            'view' => Pages\ViewIncome::route('/{record}'),
            'edit' => Pages\EditIncome::route('/{record}/edit'),
        ];
    }
}
