<x-filament::page>
    <x-filament::section>
        <x-slot name="heading">
            Daftar Buku yang sudah kamu baca nih.. Baca lagi yuk! ⬇️
        </x-slot>

        @if($readHistories->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500 text-lg">Anda belum mulai membaca buku apapun. Ayo mulai!</p>
                <a href="{{ \App\Filament\Resources\BookResource::getUrl('index') }}"
                  class="filament-button mt-4 inline-flex items-center justify-center"
                  wire:navigate>
                    Lihat Daftar Buku
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($readHistories as $history)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                        <div class="flex items-start gap-4 mb-4"> 
                            @if($history->book->cover_image)
                                <img src="{{ Storage::url($history->book->cover_image) }}"
                                    style="box-shadow: rgba(248, 222, 255, 0.25) 0px 50px 100px -10px, rgba(254, 208, 255, 0.3) 0px 30px 60px -20px;"
                                    alt="{{ $history->book->title }}"
                                    class="w-20 h-28 object-cover rounded-lg shadow-2xl flex-shrink-0" />
                            @else
                                <div class="w-20 h-28 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs text-gray-500 dark:text-gray-400 rounded-lg shadow-md flex-shrink-0">
                                    No Cover
                                </div>
                            @endif
                            <div class="flex-grow space-y-2"> 
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white leading-tight">{{ $history->book->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Oleh: {{ $history->book->author }}</p>
                            </div>
                        </div>

                    
                        <div class="space-y-2 mb-4"> 
                          
                            <div>
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-1 text-xs font-semibold text-white-600 bg-primary-100 dark:bg-gray-700 dark:text-gray-300">
                                    <x-heroicon-s-clock class="w-3 h-3" />
                                    Terakhir Dibaca: {{ $history->last_read_at->diffForHumans() }}
                                </span>
                            </div>

                            {{-- Keterangan Selesai Dibaca (jika ada) --}}
                            @if($history->finished_at)
                                <div>
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 dark:bg-green-900 dark:text-green-200">
                                        <x-heroicon-s-check-circle class="w-3 h-3" />
                                        Selesai Dibaca pada: {{ $history->finished_at->format('d F Y') }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Tombol Lanjutkan Membaca --}}
                        <div class="mt-auto pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-start">
                            {{-- PERBAIKAN: Menggunakan bookId untuk parameter ReadBookPage --}}
                            <a href="{{ \App\Filament\Pages\ReadBookPage::getUrl(['book' => $history->book->id]) }}"
                               class="filament-button inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm"
                               wire:navigate>
                                Lanjutkan Membaca
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>
</x-filament::page>