<x-filament-panels::page>
    <x-slot name="header">
        <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
            {{ static::$title }}
        </h1>
    </x-slot>

    <x-filament::section>
        @if($currentUser && $currentUser->isActiveSubscriber())
            <div class="flex flex-col items-center justify-center p-8 text-center space-y-6">
                <x-heroicon-s-check-badge class="w-20 h-20 text-green-500 animate-pulse" />

                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white leading-tight">
                    Selamat, Langganan Anda Aktif! 🎉
                </h2>

                <p class="text-lg text-gray-800 dark:text-gray-300 max-w-2xl">
                    Anda sedang menikmati paket <strong class="text-primary-600 dark:text-primary-400">{{ $packageType }}</strong>.
                    Langganan Anda akan berakhir dalam <strong class="text-primary-600 dark:text-primary-400">{{ $remainingDays }}</strong>.
                </p>

                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-inner w-full max-w-sm space-y-3">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Dimulai Sejak: <strong class="text-gray-800 dark:text-gray-200">{{ $currentUser->subscription_start_at->format('d F Y') }}</strong></p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Berakhir Pada: <strong class="text-gray-800 dark:text-gray-200">{{ $currentUser->subscription_ends_at->format('d F Y') }}</strong></p>
                </div>

                <a href="{{ \App\Filament\Resources\BookResource::getUrl('index') }}"
                   class="filament-button bg-primary-600 text-white w-full max-w-xs py-3 rounded-lg text-lg font-semibold text-center hover:bg-primary-700 transition flex items-center justify-center gap-2"
                   wire:navigate>
                    Yuk, Nikmati Buku Disini! <x-heroicon-s-arrow-right class="w-5 h-5" />
                </a>

            </div>
        @else
            {{-- Pesan jika user tidak memiliki langganan aktif --}}
            <div class="flex flex-col items-center justify-center p-8 text-center space-y-6">
                <x-heroicon-s-x-circle class="w-20 h-20 text-red-500" />
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white leading-tight">
                    Anda Belum Berlangganan Premium
                </h2>
                <p class="text-lg text-gray-800 dark:text-gray-300 max-w-2xl">
                    Untuk menikmati akses penuh ke koleksi buku premium dan fitur lainnya, silakan berlangganan sekarang.
                </p>
                <a href="{{ \App\Filament\Pages\PricingPage::getUrl() }}"
                  class="filament-button bg-primary-600 text-white w-full max-w-xs py-3 rounded-lg text-lg font-semibold text-center hover:bg-primary-700 transition flex items-center justify-center gap-2"
                  wire:navigate>
                    Pilih Paket Langganan Sekarang!
                </a>
            </div>
        @endif
    </x-filament::section>
</x-filament-panels::page>