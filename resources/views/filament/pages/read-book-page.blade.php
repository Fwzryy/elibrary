<x-filament::page>
    <div class="space-y-4 h-full">

        {{-- Judul Buku --}}
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $book->title }}</h1>
        {{-- Penulis --}}
        <p class="text-gray-700 dark:text-gray-400">{{ $book->author }} — Author</p>
        <hr class="my-4 border-gray-300 dark:border-gray-700" />

      {{-- Tampilkan Progres Membaca (hanya jika user login) --}}
        @if(Auth::check())
            <div class="mb-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Progres Anda: {{ round($progressPercentage) }}% (Halaman {{ $currentPage }} / {{ $book->total_pages ?? 'N/A' }})</p>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                </div>
            </div>
        @endif

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf_viewer.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf_viewer.min.css">

    {{-- JS untuk tracking scroll iframe --}}
    @push('scripts')
    <script>
          document.addEventListener('livewire:navigated', () => {
            const pdfUrl = "{{ Storage::url($book->file_path) }}";
            const currentPageFromPHP = {{ $currentPage }};
            const totalPagesFromPHP = {{ $book->total_pages ?? 1 }};

            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

            const viewerContainer = document.getElementById('viewerContainer');
            const viewer = document.getElementById('viewer');

            if (!viewerContainer || !viewer) {
                console.error('PDF viewer elements not found.');
                return;
              }
            const eventBus = new pdfjsViewer.EventBus(); 

            const pdfLinkService = new pdfjsViewer.PDFLinkService({
              eventBus: eventBus,
            });

            const pdfViewer = new pdfjsViewer.PDFViewer({
                container: viewerContainer,
                eventBus: eventBus,
                linkService: pdfLinkService,
              });
            pdfLinkService.setViewer(pdfViewer);

             // Muat dokumen PDF
            pdfjsLib.getDocument({ url: pdfUrl }).promise.then(pdfDocument => {
            pdfViewer.setDocument(pdfDocument);
            pdfLinkService.setDocument(pdfDocument, null);

            if (currentPageFromPHP > 1 && currentPageFromPHP <= pdfDocument.numPages) {
              pdfViewer.currentPageNumber = currentPageFromPHP;
            }

            // Event listener untuk mendeteksi perubahan halaman saat scroll 
            eventBus.on('pagechanging', function(evt) {
              const newPageNumber = evt.pageNumber; 
              const newProgressPercentage = (newPageNumber / pdfDocument.numPages) * 100;

              Livewire.dispatch('updateScrollProgress', { pageNumber: newPageNumber, progressPercentage: newProgressPercentage });
            });

          //buat update progres awal pas halaman dimuat/dirender
            eventBus.on('pagesinit', function() {
              const initialPageNumber = pdfViewer.currentPageNumber;
              const initialProgressPercentage = (initialPageNumber / pdfDocument.numPages) * 100;
              Livewire.dispatch('updateScrollProgress', { pageNumber: initialPageNumber, progressPercentage: initialProgressPercentage });
          });

          }).catch(function(exception) {
            console.error('Error loading PDF:', exception);
            alert('Gagal memuat PDF: ' + exception.message);
          });
        });
    </script>
    @endpush
</x-filament::page>