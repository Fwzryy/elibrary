<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use App\Models\Payment;
use App\Models\User;
use App\Enums\PaymentStatus;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // 
use App\Models\SubscriptionPackage; 

class UploadPaymentPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $navigationLabel = 'Unggah Bukti Pembayaran';
    protected static ?string $title = 'Unggah Bukti Pembayaran 🧾';

    protected static string $view = 'filament.pages.upload-payment-page';

    // Mendeklarasikan setiap properti form secara eksplisit
    public ?int $amount = null; // Tipe data sesuai kolom database
    public ?string $payment_method = null;
    public ?string $transaction_id = null;
    public ?array $proof_image = null; // Tetap array untuk FileUpload
    public ?string $notes = null;
    public ?int $subscription_id = null; // Ini akan diisi dari URL

    public ?string $packageSlug = null;


    public function mount(): void
    {
       $this->packageSlug = request()->query('package'); // Ambil slug dari URL
          
        $this->form->fill([
            'amount' => request()->query('amount'),
            // subscription_id akan diisi secara otomatis oleh Filament jika properti di-bind
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('amount')
                ->label('Jumlah Pembayaran Anda')
                ->numeric()
                ->prefix('Rp')
                ->required()
                ->helperText('Mohon masukkan jumlah sesuai dengan paket yang Anda pilih.'),

            Select::make('payment_method')
                ->label('Metode Pembayaran')
                ->options([
                    'bank_transfer' => 'Transfer Bank (BCA/Mandiri)',
                    'e_wallet' => 'E-Wallet (Dana/OVO)',
                ])
                ->required()
                ->placeholder('Pilih metode pembayaran'),

            TextInput::make('transaction_id')
                ->label('ID Transaksi (Opsional)')
                ->placeholder('Masukkan ID transaksi jika ada')
                ->nullable(),

            FileUpload::make('proof_image')
                ->label('Unggah Bukti Pembayaran')
                ->disk('public')
                ->directory('payment-proofs')
                ->image()
                ->maxSize(2048)
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                ->required()
                ->helperText('Unggah gambar bukti transfer Anda (JPG, PNG, WEBP, maks 2MB).'),

            Textarea::make('notes')
                ->label('Catatan Tambahan (Opsional)')
                ->rows(3)
                ->nullable()
                ->placeholder('Tulis catatan jika ada'),

            TextInput::make('subscription_id')
                ->hidden()
                ->default(fn () => $this->subscription_id), // Default dari properti
        ];
    }

    // protected function getFormModel(): string
    // {
    //     return Payment::class;
    // }

    public function submitPayment(): void
    {
        try {
            $data = $this->form->getState();

            Log::info('Form data received after validation:', $data);
            Log::info('packageSlug from component property: ' . $this->packageSlug); // Log dengan nama baru

            if (!Auth::check()) {
                Notification::make()
                    ->title('Anda harus login untuk mengunggah pembayaran.')
                    ->danger()
                    ->send();
                return;
            }

            $user = Auth::user();

            DB::beginTransaction();

             // Dapatkan ID paket langganan berdasarkan slug
            $subscriptionPackage = SubscriptionPackage::where('slug', $this->packageSlug)->first();

            if (!$subscriptionPackage) {
                throw new \Exception('Paket langganan tidak ditemukan atau tidak valid.');
            }

            $payment = Payment::create([
                'user_id' => $user->id,
                'amount' => $data['amount'],
                'status' => PaymentStatus::Pending,
                'payment_method' => $data['payment_method'],
                'transaction_id' => $data['transaction_id'],
                'subscription_id' => $subscriptionPackage->id, 
                'proof_image' => $data['proof_image'],
                'notes' => $data['notes'],
                'paid_at' => now(),
            ]);

            DB::commit();

            Notification::make()
                ->title('Bukti pembayaran berhasil diunggah!')
                ->body('Pembayaran Anda sedang dalam proses verifikasi oleh admin. Kami akan memberitahu Anda setelah disetujui.')
                ->success()
                ->send();

            // Reset form dengan mengisi ulang properti-properti komponen
            $this->reset([
                'amount',
                'payment_method',
                'transaction_id',
                'proof_image',
                'notes',
                'subscription_id',
                // 'subscription_id' tidak perlu direset karena ini diambil dari URL
            ]);

            redirect()->to(\App\Filament\Resources\BookResource::getUrl('index'));

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error uploading payment: ' . $e->getMessage(), ['user_id' => Auth::id()]); // Baris yang diperbaiki
            Notification::make()
                ->title('Gagal mengunggah bukti pembayaran!')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check() && !Auth::user()->isAdmin('admin');
    }

    public static function canAccess(): bool
    {
        return Auth::check() && !Auth::user()->hasActiveSubscription();
    }
}