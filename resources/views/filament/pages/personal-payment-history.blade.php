<x-filament-panels::page>
    <x-slot name="header">
        <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
            {{ static::$title }}
        </h1>
    </x-slot>

    <x-filament::section>
        <x-slot name="heading">
            Daftar Pembayaran Anda
        </x-slot>

        @if($userPayments->isEmpty())
            <p class="text-gray-500 dark:text-gray-400 text-center py-4">Anda belum memiliki riwayat pembayaran.</p>
        @else
            <div class="overflow-x-auto rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Paket Langganan</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Metode</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pembayaran</th>
                            <th scope="col" class="px-6 py-3">Bukti</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userPayments as $payment)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $payment->subscriptionPackage->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold
                                        @if($payment->status->value === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400
                                        @elseif($payment->status->value === 'approved') bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400
                                        @else bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400
                                        @endif">
                                        {{ $payment->status->getLabel() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $payment->payment_method }}</td>
                                <td class="px-6 py-4">{{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($payment->proof_image)
                                        <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="text-primary-600 hover:underline">Lihat Bukti</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </x-filament::section>
</x-filament-panels::page>