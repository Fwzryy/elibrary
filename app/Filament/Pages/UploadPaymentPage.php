<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\Payment;
use Filament\Pages\Page;
use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use App\Models\SubscriptionPackage;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Log; 
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder; 
use Illuminate\Support\Str;
use Filament\Forms\Components\ViewField; 
use Filament\Forms\Concerns\InteractsWithForms;

class UploadPaymentPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $navigationLabel = 'Unggah Bukti Pembayaran';
    protected static ?string $title = 'Unggah Bukti Pembayaran 🧾';

    protected static string $view = 'filament.pages.upload-payment-page';

    // Mendeklarasikan setiap properti 
    public ?int $amount = null;
    public ?array $proof_image = null; 
    public ?string $notes = null;
    public ?int $subscription_id = null; 
    public ?string $packageSlug = null;
    public ?string $payment_method = null; 
    public ?string $transaction_id = null;


    public function mount(): void
    {
      $this->packageSlug = request()->query('package');
      $this->amount = request()->query('amount');

        $this->form->fill([
          'amount' => $this->amount,
          'package' => $this->packageSlug,
        ]);
        $this->payment_method = 'qris';
        $this->transaction_id = null;
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('amount')
                ->label('Jumlah Pembayaran Anda')
                ->numeric()
                ->prefix('Rp')
                ->default($this->amount)
                ->disabled()
                ->required()
                ->helperText('Jumlah ini sudah otomatis terisi sesuai paket yang Anda pilih.')
                ->columnSpanFull(),

            Placeholder::make('package') 
                ->label('Paket Langganan')
                ->content(new HtmlString('<strong>' . Str::title(str_replace('_', ' ', $this->packageSlug ?? 'Paket Tidak Dikenali')) . '</strong>')) 
                ->columnSpanFull()
                ->extraAttributes(['class' => 'bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mb-4']),

            Placeholder::make('metode_pembayaran_qris') 
                ->label('Metode Pembayaran')
                ->content(new HtmlString('<strong>QRIS</strong>')) 
                ->hint('Pembayaran hanya melalui QRIS.') 
                ->columnSpanFull()
                ->extraAttributes(['class' => 'bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mb-4']),
            
            Placeholder::make('qris_qr_code') 
                ->label('Scan QRIS untuk Pembayaran')
                ->content(new HtmlString('
                    <div class="flex flex-col items-center justify-center">
                        <img src="' . asset('images/qris_placeholder.png') . '" alt="QRIS Code" class="w-48 h-48 mb-4 rounded-lg shadow-md" />
                        <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                            Silakan scan QRIS di atas untuk melakukan pembayaran.<br>
                            Pastikan jumlah yang dibayar sesuai: <strong>Rp ' . number_format($this->amount ?? 0, 0, ',', '.') . '</strong>
                        </p>
                    </div>
                '))
                ->columnSpanFull()
                ->extraAttributes(['class' => 'bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mb-4']),    

            FileUpload::make('proof_image')
                ->label('Unggah Bukti Pembayaran')
                ->disk('public')
                ->directory('payment-proofs')
                ->visibility('public')
                ->image()
                ->maxSize(2048)
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                ->required()
                ->helperText('Unggah gambar bukti transfer Anda (JPG, PNG, WEBP, maks 2MB).')
                ->columnSpanFull(),

            Textarea::make('notes')
                ->label('Catatan Tambahan (Opsional)')
                ->rows(3)
                ->nullable()
                ->placeholder('Tulis catatan jika ada')
                ->columnSpanFull(),
        ];
    }

    public function submitPayment(): void
    {
        try {
            $formData = $this->form->getState();

            if (!Auth::check()) {
                Notification::make()->title('Anda harus login untuk mengunggah pembayaran.')->danger()->send();
                return;
            }

            $user = Auth::user();

            DB::beginTransaction();

            $subscriptionPackage = SubscriptionPackage::where('slug', $this->packageSlug)->first();

            if (!$subscriptionPackage) {
                throw new \Exception("Paket langganan terkait pembayaran tidak ditemukan atau tidak valid. Silakan hubungi admin.");
            }

            $payment = Payment::create([
                'user_id' => $user->id,
                'amount' => $this->amount,
                'status' => PaymentStatus::Pending,
                'payment_method' => 'qris', 
                'transaction_id' => $this->transaction_id, 
                'subscription_id' => $subscriptionPackage->id, 
                'proof_image' => $formData['proof_image'], 
                'notes' => $formData['notes'], 
                'paid_at' => now(),
            ]);

            DB::commit();

            Notification::make()
                ->title('Bukti pembayaran berhasil diunggah!')
                ->body('Pembayaran Anda sedang dalam proses verifikasi oleh admin. Kami akan memberitahu Anda setelah disetujui.')
                ->success()
                ->send();

            $this->form->fill([
                'proof_image' => null,
                'notes' => null,
            ]);

            redirect()->to(\App\Filament\Pages\SubscriptionConfirmation::getUrl());

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error uploading payment: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'package_slug' => $this->packageSlug ?? 'N/A',
                'amount_prop' => $this->amount ?? 'N/A',
                'form_data' => $formData ?? null,
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
            ]);
            Notification::make()
                ->title('Gagal mengunggah bukti pembayaran!')
                ->body('Terjadi kesalahan: ' . $e->getMessage() . ' Mohon periksa log Laravel untuk detail.')
                ->danger()
                ->send();
        }
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check() && !Auth::user()->isAdmin();
    }

    public static function canAccess(): bool
    {
        return Auth::check() && !Auth::user()->hasActiveSubscription();
    }
}