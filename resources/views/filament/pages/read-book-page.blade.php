<x-filament::page>
    <div class="space-y-4">
        {{-- Tombol Kembali ke Daftar Buku --}}
        <div class="mb-4">
            <a href="{{ \App\Filament\Resources\BookResource::getUrl('index') }}"
               class="filament-button inline-flex items-center justify-center gap-1.5 rounded-lg px-4 py-2 text-sm font-semibold outline-none transition duration-75 hover:bg-gray-50 focus:ring-1 focus:ring-inset dark:hover:bg-gray-500/50 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-primary-600"
               wire:navigate>
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Kembali ke Daftar Buku
            </a>
        </div>

        <h1 class="text-2xl font-bold">{{ $book->title }}</h1>
        <p class="text-gray-600 dark:text-gray-200">{{ $book->author }}</p>
        <hr class="my-4" />
        
        {{-- Banner Iklan Upsell (opsional, bisa diganti modal di bawah) --}}
        @php
            $showTopBannerAd = Auth::check() && !Auth::user()->isAdmin() && !Auth::user()->isActiveSubscriber() && $book->is_free;
        @endphp

        @if($showTopBannerAd)
            <div class="bg-primary-600 text-white p-3 rounded-lg shadow-lg flex items-center justify-between mb-4 animate-pulse">
                <div class="flex items-center gap-2">
                    <x-heroicon-s-sparkles class="w-6 h-6 text-yellow-300" />
                    <p class="font-semibold text-sm md:text-base">Upgrade ke Premium untuk pengalaman membaca tanpa gangguan!</p>
                </div>
                <a href="{{ \App\Filament\Pages\PricingPage::getUrl() }}"
                   class="inline-flex items-center justify-center px-4 py-2 bg-white text-primary-600 rounded-lg text-sm font-semibold hover:bg-gray-100 transition duration-150"
                   wire:navigate>
                    Lihat Paket Premium &rarr;
                </a>
            </div>
        @endif
        {{-- AKHIR BANNER IKLAN UPSELL --}}

        @if ($book->file_path)
            {{-- Menggunakan iframe untuk menampilkan PDF --}}
            <div class="relative w-full" style="height: 85vh;">
                <iframe
                    src="{{ Storage::url($book->file_path) }}"
                    class="w-full h-full border-0 rounded-lg shadow-xl"
                    frameborder="0"
                    allowfullscreen
                    mozallowfullscreen
                    webkitallowfullscreen
                >
                    <p>Browser Anda tidak mendukung tampilan PDF secara langsung. Silakan <a href="{{ Storage::url($book->file_path) }}" target="_blank" class="text-blue-500 hover:underline">klik di sini untuk mengunduh PDF</a>.</p>
                </iframe>
            </div>
        @else
            {{-- Pesan jika tidak ada file PDF --}}
            <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded-lg shadow-inner" style="height: 85vh;">
                <p class="text-gray-700 dark:text-gray-300 text-lg font-medium">Buku ini belum memiliki file PDF.</p>
            </div>
        @endif
    </div>

{{-- modal iklan --}}
@if(Auth::check() && !Auth::user()->isAdmin() && !Auth::user()->isActiveSubscriber() && $book->is_free)
    <div x-data="{ showAdModal: false }"
         x-init="
             adInterval = setInterval(() => { showAdModal = true; }, 10000); 
             $watch('showAdModal', value => {
                 if (!value && adInterval) {
                    clearInterval(adInterval);
                    adInterval = setInterval(() => { showAdModal = true; }, 10000);
                 }
             });
         "
         x-show="showAdModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display: none;">

        {{-- Overlay --}}
        <div class="fixed inset-0 bg-gray-900/75" aria-hidden="true"></div>

        {{-- Modal Panel --}}
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl p-12 max-w-3xl mx-auto transform transition-all"> 
            <button type="button" x-on:click="showAdModal = false"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-400 transition">
                <x-heroicon-o-x-mark class="w-6 h-6" />
            </button>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="text-center md:text-left">
                    <x-heroicon-s-book-open class="w-24 h-24 text-primary-600 mx-auto md:mx-0 mb-4" />
                    <p class="text-gray-800 dark:text-gray-400 text-sm">
                        Temukan lebih banyak inspirasi dan pengetahuan!
                    </p>
                </div>

                <div class="space-y-4"> 
                    <h3 class="text-3xl font-extrabold text-primary-600 text-center md:text-left" style="margin-top: 20px"> 
                        <x-heroicon-s-sparkles class="w-8 h-8 inline-block align-start mr-2" /> Tingkatkan Pengalaman Membacamu!
                    </h3>
                    <p class="text-gray-800 dark:text-gray-300 text-center md:text-left">
                        Kamu sedang menikmati buku gratis, tapi ada banyak lagi yang menunggu!
                        Berlangganan Premium untuk:
                    </p>
                    <ul class="text-gray-800 dark:text-gray-200 space-y-3"> 
                        <li class="flex items-center gap-2">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-green-500" /> Akses tak terbatas ke ribuan buku Premium!
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-green-500" /> Bebas Iklan & Gangguan membaca.
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-green-500" /> Fitur riwayat baca yang lebih canggih.
                        </li>
                    </ul>
                    <div class="flex flex-col gap-4" style="margin-right: 20px; margin-bottom: 20px"> 
                        <a href="{{ \App\Filament\Pages\PricingPage::getUrl() }}"
                           class="filament-button bg-primary-600 text-white w-full py-3 rounded-lg text-lg font-semibold text-center hover:bg-primary-700 transition"
                           wire:navigate>
                            Dapatkan Akses Premium Sekarang!
                        </a>
                        <button type="button" x-on:click="showAdModal = false"
                                class="filament-button bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 w-full py-3 rounded-lg text-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                Lanjut Baca Gratis 🆓
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
    {{-- AKHIR MODAL IKLAN UPSELL --}}

    {{-- Hapus semua script dan link PDF.js dari sini, karena tidak digunakan dengan iframe --}}
    @push('scripts')
        {{-- Kosongkan blok script ini atau hapus jika tidak ada script lain yang di-push di ReadBookPage --}}
    @endpush
</x-filament::page>