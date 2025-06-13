<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DateTimePicker;

use Illuminate\Support\Facades\Auth; 

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Daftar Pengguna 👨🏻‍💻';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                  ->required()
                  ->maxLength(255),
                TextInput::make('email')
                  ->email()
                  ->required()
                  ->maxLength(255)
                  ->unique(ignoreRecord: true), // Pastikan email unik
                Select::make('role') // Field untuk role
                  ->options([
                    'admin' => 'Admin',
                    'user' => 'User',
                  ])
                  ->required()
                  ->default('user'),
                DateTimePicker::make('subscription_ends_at')
                  ->label('Subscription End Date')
                  ->nullable(), 
                TextInput::make('password')
                  ->password()
                  ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)) 
                  ->dehydrated(fn (?string $state): bool => filled($state)) 
                  ->required(fn (string $operation): bool => $operation === 'create') 
                  ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                  ->searchable()
                  ->sortable(),
                TextColumn::make('email')
                  ->searchable()
                  ->sortable(),
                TextColumn::make('role') 
                  ->badge() 
                  ->color(fn (string $state): string => match ($state) {
                      'admin' => 'success',
                      'user' => 'info',
                      default => 'gray',
                  }),
                TextColumn::make('subscription_ends_at')
                  ->dateTime()
                  ->sortable()
                  ->toggleable(isToggledHiddenByDefault: false) // Biarkan terlihat
                  ->description(fn (User $record): string => $record->hasActiveSubscription() ? 'Active' : 'Inactive')
                  ->color(fn (User $record): string => $record->hasActiveSubscription() ? 'success' : 'danger'), // Warna berdasarkan status aktif
                  
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
                Tables\Filters\SelectFilter::make('role') // Filter berdasarkan role
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ]),
                Tables\Filters\TernaryFilter::make('has_active_subscription') // Filter untuk langganan aktif
                    ->label('Active Subscription')
                    ->nullable()
                    ->query(function (Builder $query, array $data): Builder {
                        if ($data['value'] === true) {
                            return $query->whereNotNull('subscription_ends_at')->where('subscription_ends_at', '>', now());
                        }
                        if ($data['value'] === false) {
                            return $query->whereNull('subscription_ends_at')->orWhere('subscription_ends_at', '<=', now());
                        }
                        return $query;
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
            // Akan kita tambahkan nanti: SubscriptionsRelationManager, BookReadsRelationManager, PaymentsRelationManager
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'email',
        ];
    }

    // Batasi akses hanya untuk admin
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
