<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->options(Account::selectRaw("CONCAT(name, ' ', account_number) as account_info, id")
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
                Tables\Columns\TextColumn::make('created_user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expense_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expense_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expense_category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('file')
                    ->searchable(),
                Tables\Columns\TextColumn::make('warranty_until')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'view' => Pages\ViewExpense::route('/{record}'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
