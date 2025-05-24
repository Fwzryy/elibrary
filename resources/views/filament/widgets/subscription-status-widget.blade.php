<x-filament::widget>
    <x-filament::card>
        <x-slot name="heading">
            Status Langganan Anda
        </x-slot>

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
                    <p class="text-gray-500 text-sm">Anda belum memiliki langganan aktif.</p>
                    <a href="{{ url('/admin/payments/create') }}" class="filament-link text-primary-600 hover:underline">
                        Pilih Paket Langganan
                    </a>
                    {{-- Sesuaikan URL '/admin/payments/create' dengan halaman pilih paket Anda --}}
                </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget>