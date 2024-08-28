<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseCategoryResource\Pages;
use App\Models\ExpenseCategory;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

class ExpenseCategoryResource extends Resource
{
    protected static ?string $model = ExpenseCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'System Management';
    //izmanto lai veidotu secību navigationBroup esošajiem resursiem pagaidām neizmantoju
    // protected static ?int $navigationSord = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('category_name')
                    ->label('Category Name')
                    ->placeholder('Enter a unique category name')
                    ->required()
                    ->maxLength(100)
                    // šajā versijā rule metode atgriež kļūdas paziņojumu "addslashes(): Argument #1 ($string) must be of type string, Closure given"
                    // ->rules([
                    //     Rule::unique('expense_categories', 'category_name')
                    //         ->ignore(fn ($record) => $record('id')),
                    // ]),

                    // šajā versijā rule metode neļauj editot citus ievadlaukus jo atgriež paziņojumu, ka ievadlauks category name jau eksistē"
                    ->rules([
                        Rule::unique('expense_categories', 'category_name')
                            ->ignore(request()->route('record')), // Correctly pass the record ID
                    ]),

                Toggle::make('is_visible')
                    ->required()
                    ->default(1),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category_name')
                    ->searchable(),
                IconColumn::make('is_visible')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListExpenseCategories::route('/'),
            'create' => Pages\CreateExpenseCategory::route('/create'),
            'view' => Pages\ViewExpenseCategory::route('/{record}'),
            'edit' => Pages\EditExpenseCategory::route('/{record}/edit'),
        ];
    }
}
