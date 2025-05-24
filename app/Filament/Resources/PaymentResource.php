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
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Forms\Set; 
use Illuminate\Support\Facades\Storage;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Payments';
    protected static ?string $navigationLabel = 'Kelola Pembayaran 💳';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Forms\Components\Card::make([
                Select::make('user_id')
                    ->relationship('user', 'name') //nama relasi di model Payment
                    ->label('Pengguna')
                    ->required()
                    ->disabled() // Admin tidak bisa mengubah user
                    ->afterStateHydrated(function (Set $set, $state) {
                        if (Auth::check() && $state === null) { // Hanya set jika user login dan state masih null
                            $set('user_id', Auth::id());
                        }
                    }),

                TextInput::make('amount')
                    ->numeric()
                    ->label('Jumlah Pembayaran')
                    ->prefix('Rp')
                    ->required()
                    ->disabled(), //Admin tidak bisa mengubah jumlah

                TextInput::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->required()
                    ->disabled(), //Admin tidak bisa mengubah metode

                TextInput::make('transaction_id')
                    ->label('ID Transaksi')
                    ->nullable()
                    ->disabled(),

                TextInput::make('subscription_id')
                    ->label('ID Paket Langganan')
                    ->nullable()
                    ->disabled(),

                FileUpload::make('proof_image')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->disk('public')
                    ->directory('payment-proofs') // Folder tempat gambar akan disimpan
                    ->previewable(true)
                    ->downloadable()
                    ->visibility('private') // Agar tidak bisa diakses langsung via URL publik
                    ->disabled() // Admin tidak bisa mengubah bukti
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),

                Textarea::make('notes')
                    ->label('Catatan User')
                    ->rows(3)
                    ->nullable()
                    ->disabled(),

                Select::make('status')
                    ->label('Status')
                    ->options(\App\Enums\PaymentStatus::class) // Menggunakan Enum
                    ->required()
                    ->reactive() // Membuat form bereaksi terhadap perubahan status
                    ->columnSpanFull(),
              
                // Tampilkan DateTimePicker hanya jika status Approved
                    DateTimePicker::make('paid_at')
                    ->label('Tanggal Pembayaran')
                    ->nullable()
                    ->default(now()) // Default ke waktu sekarang saat dibuat
                    ->hidden(fn (Forms\Get $get): bool => $get('status') !== \App\Enums\PaymentStatus::Approved)
                    ->required(fn (Forms\Get $get): bool => $get('status') === \App\Enums\PaymentStatus::Approved)
                    ->seconds(false)
                    ->columnSpanFull(),
            ])->columns(2), // 2 kolom dalam setiap card;
          ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR') // Format sebagai mata uang Rupiah
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label('Metode'),
                TextColumn::make('subscription_id')
                    ->label('ID Paket')
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan secara default

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([ // Warna diambil dari Enum (HasColor)
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    ])
                    ->sortable(),

                ImageColumn::make('proof_image')
                    ->label('Bukti')
                    ->disk('public') // Opsional, tapi baik untuk kejelasan
                    ->size(40)
                    ->circular()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('paid_at')
                    ->label('Dibayar Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
              SelectFilter::make('status')
                    ->options(\App\Enums\PaymentStatus::class) // Filter berdasarkan Enum
                    ->label('Filter Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Custom action untuk Approve
                Action::make('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Payment $record): bool => $record->status === \App\Enums\PaymentStatus::Pending)
                    ->requiresConfirmation()
                    ->modalHeading('Approve Pembayaran?')
                    ->modalDescription('Apakah Anda yakin ingin menyetujui pembayaran ini? Status user akan diperbarui.')
                    ->action(function (Payment $record) {
                        // Logika APPROVE
                        $record->status = \App\Enums\PaymentStatus::Approved;
                        $record->approved_at = now(); // Set tanggal disetujui
                        $record->save();

                        // Update status langganan user
                        $user = $record->user;
                        $user->subscription_start_at = now(); // Set tanggal mulai langganan

                        // Hitung tanggal berakhir berdasarkan package_name / subscription_id
                        // Anda perlu membuat logic ini
                        // Contoh sederhana (sesuaikan dengan ID paket Anda)
                        if ($record->subscription_id == 30) { // Misal ID paket 30 hari
                            $user->subscription_ends_at = now()->addDays(30);
                        } elseif ($record->subscription_id == 90) { // Misal ID paket 90 hari
                            $user->subscription_ends_at = now()->addDays(90);
                        } else {
                            // Default atau handling jika subscription_id tidak dikenal
                            $user->subscription_ends_at = now()->addDays(30); // Default 30 hari
                        }

                        // Jika Anda punya kolom is_subscriber di User
                        // $user->is_subscriber = true;

                        $user->save();

                        \Filament\Notifications\Notification::make()
                            ->title('Pembayaran disetujui!')
                            ->success()
                            ->send();
                    }),
                // Custom action untuk Reject (opsional)
                Action::make('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Payment $record): bool => $record->status === \App\Enums\PaymentStatus::Pending)
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pembayaran?')
                    ->modalDescription('Apakah Anda yakin ingin menolak pembayaran ini? Ini tidak dapat diurungkan.')
                    ->action(function (Payment $record) {
                        $record->status = \App\Enums\PaymentStatus::Rejected;
                        $record->save();

                        \Filament\Notifications\Notification::make()
                            ->title('Pembayaran ditolak.')
                            ->danger()
                            ->send();
                    }),
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

    public static function getModelLabel(): string
    {
        return 'Permintaan Pembayaran';
    }
    public static function getPluralModelLabel(): string
    {
        return 'Permintaan Pembayaran';
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['user.name', 'amount'];
    }

    public static function canViewAny(): bool
    {
        return (Auth::user())->isAdmin();
    }
}
