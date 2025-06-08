<x-filament-widgets::widget>
    <x-filament::card>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            {{ static::$heading }}
        </h3>

        @if($lastReadHistory && $lastReadHistory->book)
            <div class="flex items-center gap-4">
                {{-- Cover Buku --}}
                @if($lastReadHistory->book->cover_image)
                    <img src="{{ Storage::url($lastReadHistory->book->cover_image) }}"
                        style="box-shadow: rgba(248, 222, 255, 0.25) 0px 50px 100px -10px, rgba(254, 208, 255, 0.3) 0px 30px 60px -20px;"
                        alt="{{ $lastReadHistory->book->title }}"
                        class="w-24 h-32 object-cover rounded-lg shadow-md" />
                @else
                    <div class="w-24 h-32 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs text-gray-500 dark:text-gray-400 rounded-lg shadow-md">
                        No Cover
                    </div>
                @endif

                <div class="flex-grow space-y-2">
                    {{-- Judul dan Penulis --}}
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white leading-tight">
                        {{ $lastReadHistory->book->title }}
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Oleh: {{ $lastReadHistory->book->author }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Terakhir Dibaca: {{ $lastReadHistory->last_read_at->diffForHumans() }}
                    </p>

                  <a href="{{ \App\Filament\Pages\ReadBookPage::getUrl(['book' => $lastReadHistory->book->id]) }}"
                      class="filament-button inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm mt-3"
                      wire:navigate>
                        Lanjutkan Membaca
                        <x-heroicon-s-arrow-right class="w-4 h-4 ml-1" />
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500 text-lg mb-4">Anda belum memulai membaca buku apapun. Ayo temukan buku favorit Anda!</p>
               <a href="{{ \App\Filament\Resources\BookResource::getUrl('index') }}"
                   class="filament-button inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm"
                   wire:navigate>
                    Telusuri Koleksi Buku
                </a>
            </div>
        @endif
    </x-filament::card>
</x-filament-widgets::widget>