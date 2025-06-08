<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReadHistoryResource\Pages;
use App\Filament\Resources\ReadHistoryResource\RelationManagers;
use App\Models\ReadHistory; 
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ReadHistoryResource extends Resource
{
    protected static ?string $model = ReadHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Pengelolaan Library';
    protected static ?string $navigationLabel = 'Data Riwayat Baca';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('book_id')
                    ->relationship('book', 'title')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('last_page_read')
                    ->numeric()
                    ->nullable(),
                Forms\Components\TextInput::make('progress_percentage')
                    ->numeric()
                    ->step(0.01)
                    ->nullable(),
                Forms\Components\DateTimePicker::make('last_read_at')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('finished_at')
                    ->label('Selesai Dibaca Pada')
                    ->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('book.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_page_read')
                    ->label('Halaman Terakhir')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('progress_percentage')
                    ->label('Progres (%)')
                    ->formatStateUsing(fn (string $state): string => "{$state}%")
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_read_at')
                    ->label('Terakhir Dibaca')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('finished_at')
                    ->label('Selesai Dibaca')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), 
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
            'index' => Pages\ListReadHistories::route('/'),
            'create' => Pages\CreateReadHistory::route('/create'),
            'edit' => Pages\EditReadHistory::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        return (Auth::user())->isAdmin();
    }
}