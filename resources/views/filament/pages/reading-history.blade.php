<x-filament::page>
    <x-filament::section>
        <x-slot name="heading">
            Riwayat Baca Anda
        </x-slot>

        @if($readHistories->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500 text-lg">Anda belum mulai membaca buku apapun. Ayo mulai!</p>
                <a href="{{ \App\Filament\Resources\BookResource::getUrl('index') }}" class="filament-button mt-4 inline-flex items-center justify-center">
                    Lihat Daftar Buku
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($readHistories as $history)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $history->book->title }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">Oleh: {{ $history->book->author }}</p>

                        <p class="text-gray-500 text-sm">Terakhir Dibaca: {{ $history->last_read_at->diffForHumans() }}</p>

                        @if($history->last_page_read)
                            <p class="text-gray-500 text-sm">Halaman Terakhir: {{ $history->last_page_read }}</p>
                        @endif

                        @if($history->progress_percentage !== null)
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2 dark:bg-gray-700">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $history->progress_percentage }}%"></div>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ round($history->progress_percentage) }}% Selesai</p>
                        @endif

                        @if($history->finished_at)
                            <p class="text-green-500 text-sm mt-2 font-semibold">✅ Selesai Dibaca!</p>
                        @endif

                        <a href="{{ \App\Filament\Pages\ReadBookPage::getUrl(['book' => $history->book->id]) }}"
                           class="filament-button mt-4 inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm"
                           wire:navigate>
                            Lanjutkan Membaca
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>
</x-filament::page>