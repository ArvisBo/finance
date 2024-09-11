<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeResource\Pages;
use App\Filament\Resources\IncomeResource\RelationManagers;
use App\Models\Account;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationGroup = 'Expenses and Incomes';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('created_user_id')
                    ->default(fn () => auth()->id())
                    ->disabled()
                    ->dehydrated()
                    ->options(User::all()->mapWithKeys(function ($user) {
                        return [$user->id => $user->name . ' ' . $user->surname];
                    })),
                Select::make('income_category_id')
                    ->relationship('incomeCategory', 'name')
                    ->required()
                    ->searchable()
                    ->label('Income category')
                    ->placeholder('Select an income Category')
                    ->options(IncomeCategory::visible()->pluck('income_category_name', 'id')),
                Select::make('account_id')
                    ->default(fn () => optional(auth()->user())->default_account_id)
                    ->options(Account::selectRaw("CONCAT(name, ' ', account_number) as account_info, id")
                        ->where('account_owner_id', auth()->id())
                        ->pluck('account_info', 'id')
                    )
                    ->searchable()
                    ->required(),
                DatePicker::make('income_date')
                    ->default(now())
                    ->label('Income date')
                    ->format('Y-m-d'),
                TextInput::make('amount')
                    ->label('Income amount')
                    ->minValue(0)
                    ->rule('regex:/^\d+([,.]\d{1,2})?$/') // Allows entering "." and ","
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Ja lietotājs ievada "," tas tiks nomainīts uz "."
                        $formattedPrice = str_replace(',', '.', $state);
                        // nomaina uz updated formātu
                        $set('amount', $formattedPrice);
                    }),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Income::visible()) // nodrošina, ka tiek rādīti tikai ielogotā lietotāja ieraksti expense modelī methode scopeVisible
            ->columns([
                TextColumn::make('incomeCreator.name')
                ->label('Name')
                ->formatStateUsing(function ($record) {
                    return $record->incomeCreator->name . ' ' . $record->incomeCreator->surname;
                })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('incomeCategory.income_category_name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('incomeAccount.name')
                    ->label('Account name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('incomeAccount.account_number')
                    ->label('Account number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('income_date')
                    ->date('Y-m-d')
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('EUR', locale: 'lv')
                    ->sortable()
                    ->summarize(Sum::make()
                        ->money('EUR', locale: 'lv')
                        ->label('Total incomes')),
                TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('incomeCategory', 'income_category_name'),
                SelectFilter::make('account_id')
                    ->label('Account')
                    ->default(fn () => optional(auth()->user())->default_account_id) // šo varbūt nevajag, jāskatās kā būs lietojot
                    ->relationship('incomeAccount', 'name', fn(Builder $query)=>$query->where('account_owner_id', auth()->id())),

                Filter::make('expense_date')
                    ->label('Date Range')
                    ->columnSpan(2)
                    ->form([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('incomes_from')
                                    ->native(false)
                                    ->label('From')
                                    ->placeholder('YYYY-MM-DD')
                                    ->displayFormat('Y-m-d')
                                    ->firstDayOfWeek(1)
                                    ->columnSpan(1),
                                DatePicker::make('incomes_until')
                                    ->native(false)
                                    ->label('Until')
                                    ->placeholder('YYYY-MM-DD')
                                    ->displayFormat('Y-m-d')
                                    ->firstDayOfWeek(1)
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['incomes_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['incomes_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })

            ], FiltersLayout::AboveContent) // filtri vienmēr atvērti
            // ], FiltersLayout::Modal) //filtri tiks atvērti kā modal logs
            // ], FiltersLayout::AboveContentCollapsible) // filtrus būs iespējams minimizēt

            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ], position: ActionsPosition::BeforeColumns)

            ->defaultSort('income_date', 'desc')

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
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncome::route('/create'),
            'view' => Pages\ViewIncome::route('/{record}'),
            'edit' => Pages\EditIncome::route('/{record}/edit'),
        ];
    }
}
