<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms; // Kita tetap butuh ini untuk FileUpload internal
use Filament\Forms\Contracts\HasForms; // Kita tetap butuh ini
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\WithFileUploads; // <<< PENTING: Import trait ini untuk upload file
use Illuminate\Support\Facades\Storage; // Untuk menghapus foto lama

class UserProfile extends Page implements HasForms // Pastikan tetap implements HasForms
{
    use InteractsWithForms; // Gunakan trait untuk form (dibutuhkan oleh FileUpload di modal)
    use WithFileUploads; // <<< PENTING: Gunakan trait ini untuk upload file

    protected static ?string $title = 'Profil Saya';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Akun Saya';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.user-profile';

    public ?User $user;
    public $newProfilePhoto; // <<< PERBAIKAN: Properti publik untuk upload foto baru


    public function mount(): void
    {
        $this->user = Auth::user();
        // Tidak perlu fill form lagi di sini karena tidak ada form besar
    }

    // <<< PERBAIKAN: Hapus metode getFormSchema() dan save() yang lama >>>
    // protected function getFormSchema(): array { ... }
    // public function save(): void { ... }
    // <<< AKHIR PERBAIKAN >>>


    /**
     * Metode Livewire untuk menyimpan foto profil baru.
     * Dipanggil dari Blade saat user upload foto.
     */
    public function saveProfilePhoto(): void // <<< PERBAIKAN: Metode baru untuk menyimpan foto
    {
        $this->validate([
            'newProfilePhoto' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,webp'], // Validasi foto
        ]);

        if ($this->newProfilePhoto) {
            // Hapus foto lama jika ada
            if ($this->user->profile_photo_path) {
                Storage::disk('public')->delete($this->user->profile_photo_path);
            }

            // Simpan foto baru
            $path = $this->newProfilePhoto->store('profile-photos', 'public');
            $this->user->profile_photo_path = $path;
            $this->user->save();

            Notification::make()
                ->title('Foto profil berhasil diperbarui!')
                ->success()
                ->send();
        } else {
             // Jika newProfilePhoto null dan user memang menghapus foto (opsional)
             if ($this->user->profile_photo_path) {
                Storage::disk('public')->delete($this->user->profile_photo_path);
                $this->user->profile_photo_path = null;
                $this->user->save();
                Notification::make()
                    ->title('Foto profil berhasil dihapus!')
                    ->success()
                    ->send();
             }
        }
        $this->newProfilePhoto = null; // Reset properti upload setelah simpan
    }


    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && ! $user->isAdmin();
    }

    public static function shouldBeVisible(): bool
    {
        $user = Auth::user();
        return $user && ! $user->isAdmin();
    }
}