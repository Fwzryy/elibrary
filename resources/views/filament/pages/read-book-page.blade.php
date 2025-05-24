<x-filament::page>
    <div class="space-y-4 h-full">
        {{-- Judul Buku --}}
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $book->title }}</h1>
        {{-- Penulis --}}
        <p class="text-gray-700 dark:text-gray-400">{{ $book->author }} — Author</p>
        <hr class="my-4 border-gray-300 dark:border-gray-700" />

        @if ($book->file_path)
            {{-- Wrapper untuk Iframe --}}
            <div class="relative w-full" style="height: 85vh;">
                <iframe
                    src="{{ Storage::url($book->file_path) }}"
                    class="w-full h-full border-0 rounded-lg shadow-xl" 
                    frameborder="0"
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
</x-filament::page>