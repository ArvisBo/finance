<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;


class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Expenses and Incomes';
    protected static ?int $navigationSort = 1;

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
                Select::make('account_id')
                    ->default(fn () => optional(auth()->user())->default_account_id)
                    ->options(Account::selectRaw("CONCAT(name, ' ', account_number) as account_info, id")
                        ->where('account_owner_id', auth()->id())
                        ->pluck('account_info', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('expense_category_id')
                    ->relationship('expenseCategory', 'name')
                    ->required()
                    ->searchable()
                    ->label('Expense category')
                    ->placeholder('Select an expense Category')
                    ->options(ExpenseCategory::visible()->pluck('expense_category_name', 'id')),
                TextInput::make('expense_name')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('expense_date')
                    ->default(now())
                    ->label('Purchase date')
                    ->format('Y-m-d'),
                TextInput::make('count')
                    ->label('Count')
                    ->default(1)
                    ->required()
                    ->integer()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $price = $get('unit_price');
                        $set('total_price', $state * $price);
                    }),
                TextInput::make('unit_price')
                ->label('Unit price')
                ->minValue(0)
                ->rule('regex:/^\d+([,.]\d{1,2})?$/') // Atļauj ievadīt "." un  ","
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    // Ja lietotājs ievada "," tas tiks nomainīts uz "."
                    $formattedPrice = str_replace(',', '.', $state);

                    // nomaina uz updated formātu
                    $set('unit_price', $formattedPrice);

                    // aprēķina un uzstāda total_price vērtību
                    $count = $get('count');
                    $set('total_price', $count * $formattedPrice);
                }),
                TextInput::make('total_price')
                    ->label('Total price')
                    ->numeric()
                    ->step(0.01)
                    ->disabled()
                    ->dehydrated(),
                FileUpload::make('file')
                    ->disk('public')->directory('files') //vieta kur tiek glabāti pievienotie faili storage/app/public/receipts
                    ->visibility('public')
                    ->downloadable()
                    ->deleteUploadedFileUsing(function ($file) {
                        // Dzēš veco failu, ja tiek augšupielādēs vai izdzēsts formā esošais fails
                        Storage::disk('public')->delete($file);
                    }),
                Textarea::make('additional_information')
                    ->columnSpanFull(),
                DatePicker::make('warranty_until')
                    ->format('Y-m-d'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Expense::visible()) // nodrošina, ka tiek rādīti tikai ielogotā lietotāja ieraksti expense modelī methode scopeVisible
            ->columns([
                TextColumn::make('expenseCreator.name')
                ->label('Name')
                ->formatStateUsing(function ($record) {
                    return $record->expenseCreator->name . ' ' . $record->expenseCreator->surname;
                })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('expenseCategory.expense_category_name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('expense_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('expense_date')
                    ->date('Y-m-d')
                    ->sortable(),
                TextColumn::make('expenseAccount.name')
                    ->label('Account name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('expenseAccount.account_number')
                    ->label('Account number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('count')
                    ->numeric()
                    ->sortable()
                    ->Toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('unit_price')
                    ->money('EUR', locale: 'lv')
                    ->sortable()
                    ->Toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('total_price')
                    ->money('EUR', locale: 'lv')
                    ->sortable()
                    ->summarize(Sum::make()
                        ->money('EUR', locale: 'lv')
                        ->label('Total expenses')),
                ImageColumn::make('file')
                    ->Toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('warranty_until')
                    ->date('Y-m-d')
                    ->sortable()
                    ->Toggleable(isToggledHiddenByDefault: true),
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
                    ->relationship('expenseCategory', 'expense_category_name'),
                SelectFilter::make('account_id')
                    ->label('Account')
                    ->default(fn () => optional(auth()->user())->default_account_id) // šo varbūt nevajag, jāskatās kā būs lietojot
                    ->relationship('expenseAccount', 'name', fn(Builder $query) => $query->where('account_owner_id', auth()->id())),

                Filter::make('expense_date')
                    ->label('Date Range')
                    ->columnSpan(2)
                    ->form([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('expenses_from')
                                    ->native(false)
                                    ->label('From')
                                    ->placeholder('YYYY-MM-DD')
                                    ->displayFormat('Y-m-d')
                                    ->firstDayOfWeek(1)
                                    ->columnSpan(1),
                                DatePicker::make('expenses_until')
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
                                $data['expenses_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['expenses_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })

            ],FiltersLayout::AboveContent)
            // FiltersLayout::Modal)
            // FiltersLayout::AboveContentCollapsible)

            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ], position: ActionsPosition::BeforeColumns)

            ->defaultSort('expense_date', 'desc')

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
