<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Library';
    protected static ?string $navigationLabel = 'Subscription Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->label('User')
                    // Tambahkan logging di sini
                    ->getSearchResultsUsing(fn (string $search) =>
                        \App\Models\User::where('name', 'like', "%{$search}%")->limit(50)->get()->mapWithKeys(fn ($record) => [$record->getKey() => $record->getAttribute('name')])
                    )
                    ->getOptionLabelUsing(fn ($value): ?string => \App\Models\User::find($value)?->name),

                     // Tanggal Mulai Langganan
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->default(now())
                    ->label('Start Date'),

                    // Tanggal Berakhir Langganan
                Forms\Components\DatePicker::make('end_date')
                    ->required()
                    ->label('End Date')
                    ->minDate(fn (Forms\Get $get) => $get('start_date') ? Carbon::parse($get('start_date')) : now()),

                Forms\Components\Select::make('status')
                    ->label('Status Langganan')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                        'expired' => 'Kadaluarsa',
                        'pending' => 'Pending',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->required()
                    ->default('pending'),

                // Forms\Components\Toggle::make('is_active')
                //     ->label('Is Active?')
                //     ->default(true)
                //     ->inline(false),

                Forms\Components\TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->step(0.01),
                Forms\Components\TextInput::make('currency')
                    ->label('Currency')
                    ->maxLength(255)
                    ->default('IDR'),

                Forms\Components\TextInput::make('duration_days')
                    ->label('Duration (Days)')
                    ->numeric()
                    ->integer()
                    ->minValue(1),

                Forms\Components\Select::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'manual' => 'Manual Transfer',
                        // Tambahkan opsi pembayaran lain sesuai kebutuhan
                    ])
                    ->nullable(),

                Forms\Components\TextInput::make('transaction_id')
                    ->label('Transaction ID')
                    ->nullable()
                    ->maxLength(255),

                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->nullable()
                    ->maxLength(65535),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Nama User (relasi)
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('User Name'),
                
                // Tanggal Mulai
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),

                // Tanggal Berakhir
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
              
                // Status Langganan (Text dengan badge)
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Langganan')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                      'active' => 'success',
                      'inactive' => 'danger',
                      'expired' => 'warning',
                      'pending' => 'gray',
                      'cancelled' => 'gray',
                      default => 'primary',
                }),
                // Status Aktif (computed boolean)
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable()
                    ->getStateUsing(fn (Subscription $record): bool => $record->status === 'active' && $record->end_date->isFuture()),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->label('Currency'),
                Tables\Columns\TextColumn::make('duration_days')
                    ->label('Duration (Days)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method'),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('Transaction ID'),


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
                Tables\Filters\SelectFilter::make('user_id') // Filter berdasarkan user
                    ->relationship('user', 'name')
                    ->label('User'),

                Tables\Filters\TernaryFilter::make('is_active') // Filter untuk aktif/tidak aktif
                    ->label('Is Active')
                    ->boolean(),
                    
                    // Filter berdasarkan Status Langganan
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Langganan')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                        'expired' => 'Kadaluarsa',
                        'pending' => 'Pending',
                        'cancelled' => 'Dibatalkan',
                    ]),
                Tables\Filters\Filter::make('end_date') // Filter untuk langganan yang akan berakhir / sudah berakhir
                    ->form([
                        Forms\Components\DatePicker::make('ends_before')
                            ->label('Ends Before'),
                        Forms\Components\DatePicker::make('ends_after')
                            ->label('Ends After'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['ends_before'],
                                fn (Builder $query, $date): Builder => $query->whereDate('end_date', '<=', $date),
                            )
                            ->when(
                                $data['ends_after'],
                                fn (Builder $query, $date): Builder => $query->whereDate('end_date', '>=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }

    // public static function getGloballySearchableAttributes(): array
    // {
    //      return [
    //      ];
    // }

    // Authorization: Hanya admin yang bisa mengelola langganan
    public static function canViewAny(): bool
    {
        return (Auth::user())->isAdmin();
    }

    public static function canCreate(): bool
    {
        return (Auth::user())->isAdmin();
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return (Auth::user())->isAdmin();
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return (Auth::user())->isAdmin();
    }

    public static function canDeleteAny(): bool
    {
        return (Auth::user())->isAdmin();
    }
}

