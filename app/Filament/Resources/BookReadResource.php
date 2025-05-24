<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookReadResource\Pages;
use App\Filament\Resources\BookReadResource\RelationManagers;
use App\Models\BookRead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class BookReadResource extends Resource
{
    protected static ?string $model = BookRead::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Library';
    protected static ?string $navigationLabel = 'Riwayat Baca ⌛';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
                

    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                  ->label('User')
                  ->sortable()
                  ->searchable(),

                TextColumn::make('book.title')
                  ->label('Book')
                  ->sortable()
                  ->searchable(),
                
                TextColumn::make('last_page_read')
                  ->label('Last Page Read')
                  ->sortable(),

                TextColumn::make('progress_percentage')
                  ->label('Progress (%)')
                  ->sortable(),

                TextColumn::make('last_read_at')
                  ->label('Last Read At')
                  ->dateTime()
                  ->sortable(),

                TextColumn::make('created_at')
                  ->label('Recorded On')
                  ->dateTime()
                  ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListBookReads::route('/'),
            'create' => Pages\CreateBookRead::route('/create'),
            'edit' => Pages\EditBookRead::route('/{record}/edit'),
        ];
    }
    // public static function canViewAny(): bool
    // {
    //   return (Auth::user())->isAdmin() || Auth::user()->id == request()->route('record')->user_id;
    // }

    public static function canCreate(): bool
    {
        return (Auth::user())->isAdmin();
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
         // Admin bisa edit semua, user hanya bisa edit punya sendiri
        return (Auth::user())->isAdmin() || Auth::user()->id == $record->user_id;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        // Admin bisa delete semua, user hanya bisa delete punya sendiri
      return (Auth::user())->isAdmin() || Auth::user()->id == $record->user_id;
    }
}
