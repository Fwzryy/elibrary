<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Facades\Auth; // Import Auth

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Library';
    protected static ?string $navigationLabel = 'Payments Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                    Select::make('subscription_id')
                    ->label('Subscription')
                    ->relationship('subscription', 'id')
                    ->nullable(),

                TextInput::make('amount')
                    ->label('Amount')
                    ->required()
                    ->numeric(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ])
                    ->required(),

                TextInput::make('payment_method')
                    ->label('Payment Method')
                    ->nullable(),

                TextInput::make('transaction_id')
                    ->label('Transaction ID')
                    ->nullable(),

                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->nullable(),

                DateTimePicker::make('paid_at')
                    ->label('Paid At')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('user.name')->label('User')->sortable()->searchable(),
                TextColumn::make('subscription.id')->label('Subscription ID')->sortable(),
                TextColumn::make('amount')->money('idr', true)->sortable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                        default => 'Unknown',
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'gray',
                        default => 'secondary',
                    })
                    ->sortable(),
                TextColumn::make('payment_method')->label('Method')->sortable(),
                TextColumn::make('transaction_id')->label('Txn ID')->sortable(),
                TextColumn::make('paid_at')->label('Paid At')->dateTime()->sortable(),
                TextColumn::make('created_at')->label('Created')->dateTime('d M Y')->sortable()
            ])
            ->filters([
              Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending'   => 'Pending',
                    'completed' => 'Completed',
                    'failed'    => 'Failed',
                    'refunded'  => 'Refunded',
        ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('markCompleted')
                ->label('Mark Completed')
                ->action(fn(Payment $record) => $record->update(['status' => 'completed']))
                ->visible(fn(Payment $record) => $record->status !== 'completed'),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
