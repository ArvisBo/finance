<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
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
use Illuminate\Support\Facades\Auth;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Expenses';



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
                    ->options(ExpenseCategory::all()->pluck('category_name', 'id'))
                    ->searchable()
                    ->native(false),
                TextInput::make('product_name'),
                DatePicker::make('date')
                    ->format('Y-m-d'),
                    // šis ir gadījumiem, ja vajag automātiski aizpildīt warranty_until pieplusojot 2gadus automātiski
                    // ->reactive()
                    // ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    //     $newDate = Carbon::parse($state)->addYears(2)->format('Y-m-d');
                    //     $set('warranty_until', $newDate);
                    // }),
                TextInput::make('count')
                    ->label('Count')
                    ->default(1)
                    ->required()
                    ->integer()
                    ->reactive() // This makes the input field reactive to changes
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $price = $get('price');
                        $set('total_price', $state * $price);
                    }),

                TextInput::make('price')
                ->label('Price')
                    ->numeric()
                    ->inputMode('decimal')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $count = $get('count');
                        $set('total_price', $count * $state);
                    }),

                TextInput::make('total_price')
                ->label('Total price')
                ->numeric()
                // ->required()
                ->disabled(), // Disable the field to prevent manual changes

                Hidden::make('total_price')
                ->default(0)
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $count = $get('count');
                    $price = $get('price');
                    $set('total_price', $count * $price);
                }),

                FileUpload::make('receipt_image'),
                TextInput::make('additional_information'),
                DatePicker::make('warranty_until')
                    ->format('Y-m-d'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User name')
                    ->sortable(),
                TextColumn::make('expencecategory.category_name')
                    ->label('Category Name')
                    ->sortable(),
                TextColumn::make('product_name')
                    ->sortable(),
                TextColumn::make('date')->date('Y-m-d')
                    ->sortable(),
                TextColumn::make('count')
                    ->sortable(),
                TextColumn::make('price')
                    ->sortable(),
                TextColumn::make('total_price')
                ->label('Total price')
                    ->sortable(),
                ImageColumn::make('receipt_image')
                    ->sortable(),
                TextColumn::make('additional_information')
                    ->sortable(),
                TextColumn::make('warranty_until')->date('Y-m-d')
                    ->sortable(),
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
        return 'Expenses for ' . ($user ? $user->name : 'Guest');
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
