<x-filament::page>
    <div class="space-y-4 h-full">

        {{-- Judul Buku --}}
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $book->title }}</h1>
        {{-- Penulis --}}
        <p class="text-gray-700 dark:text-gray-400">{{ $book->author }} — Author</p>
        <hr class="my-4 border-gray-300 dark:border-gray-700" />
        
      {{-- @if(Auth::check())
        <div class="mb-4">
            <p class="text-sm text-gray-500">Progres Anda: {{ round($progressPercentage) }}% (Halaman {{ $currentPage }} / {{ $book->total_pages }})</p>
            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
            </div>
        </div>
        @endif --}}

        @if ($book->file_path)
            <div class="relative w-full" style="height: 85vh;">
              <div class="mb-4">
                <a href="{{ \App\Filament\Resources\BookResource::getUrl() }}"
                  class="filament-button inline-flex items-center justify-center gap-1.5 rounded-lg px-4 py-2 text-sm font-semibold outline-none transition duration-75 hover:bg-gray-50 focus:ring-1 focus:ring-inset dark:hover:bg-gray-500/50 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-primary-600"wire:navigate>
                    <x-heroicon-o-arrow-left class="w-4 h-4" />
                    Kembali ke Daftar Buku
                </a>
            </div>
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
            <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded-lg shadow-inner" style="height: 85vh;"> 
                <p class="text-gray-700 dark:text-gray-300 text-lg font-medium">Buku ini belum memiliki file PDF.</p>
            </div>
      @endif
    </div>

    {{-- JS untuk tracking scroll iframe --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const iframe = document.getElementById('pdf-reader');

            const interval = setInterval(() => {
                try {
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    const scrollTop = iframeDoc.documentElement.scrollTop || iframeDoc.body.scrollTop;
                    const scrollHeight = iframeDoc.documentElement.scrollHeight || iframeDoc.body.scrollHeight;
                    const clientHeight = iframeDoc.documentElement.clientHeight || iframeDoc.body.clientHeight;

                    const scrollPercentage = Math.min(100, (scrollTop / (scrollHeight - clientHeight)) * 100);
                    const totalPages = {{ $book->total_pages }};
                    const estimatedPage = Math.max(1, Math.round((scrollPercentage / 100) * totalPages));

                    // Kirim data ke Livewire
                    Livewire.dispatch('updateScrollProgress', {
                        pageNumber: estimatedPage,
                        progressPercentage: scrollPercentage.toFixed(2)
                    });

                } catch (e) {
                    // iframe belum siap atau cross-origin error
                }
            }, 5000); // setiap 5 detik

            window.addEventListener('beforeunload', () => clearInterval(interval));
        });
    </script>
    @endpush
</x-filament::page>