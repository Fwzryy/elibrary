<x-filament::widget>
    <x-filament::card>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            {{ static::$heading }}
        </h3>

        <div class="space-y-4">
            <div>
                <p class="text-gray-500 text-sm">Status:</p>
                <p class="text-lg font-semibold">{{ $subscriptionStatus }}</p>
            </div>

            @if ($packageDetails)
                <div>
                    <p class="text-gray-500 text-sm">Paket Langganan:</p>
                    <p class="text-lg font-semibold">{{ $packageDetails }}</p>
                </div>
            @endif

            @if ($startDate)
                <div>
                    <p class="text-gray-500 text-sm">Dimulai Sejak:</p>
                    <p class="text-lg font-semibold">{{ $startDate }}</p>
                </div>
            @endif

            @if ($endDate)
                <div>
                    <p class="text-gray-500 text-sm">Berakhir Pada:</p>
                    <p class="text-lg font-semibold">{{ $endDate }}</p>
                </div>
            @endif

            @if ($remainingDays && $subscriptionStatus === 'Aktif')
                <div>
                    <p class="text-gray-500 text-sm">Sisa Hari:</p>
                    <p class="text-lg font-semibold">{{ $remainingDays }}</p>
                </div>
            @endif

            @if ($subscriptionStatus === 'Belum Berlangganan' || $subscriptionStatus === 'Kadaluarsa')
                <div>
                    <p class="text-gray-500 text-sm">Anda belum memiliki langganan aktif. ❌</p>
                    <a href="{{ url('/admin/payments/create') }}" class="filament-link text-white hover:underline filament-button inline-flex items-center justify-center px-4 py-2 bg-primary-600 rounded-lg hover:bg-primary-700 text-sm mt-3 "
                      wire:navigate>
                        Pilih Paket Langganan ✨
                    </a>
                
                </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget>