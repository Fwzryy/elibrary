<x-filament::page>
    <x-filament::section>
      <style>
        .button {
          --bg: #000;
          --hover-bg: #d190ff;
          --hover-text: #000;
          color: #fff;
          cursor: pointer;
          border: 1px solid var(--bg);
          border-radius: 4px;
          padding: 0.8em 2em;
          background: var(--bg);
          transition: 0.2s;
        }

        .button:hover {
          color: var(--hover-text);
          transform: translate(-0.25rem, -0.25rem);
          background: var(--hover-bg);
          box-shadow: 0.25rem 0.25rem var(--bg);
        }

        .button:active {
          transform: translate(0);
          box-shadow: none;
        }
      </style>
        <x-slot name="heading">
            <div class="flex items-center justify-center gap-2">
                <x-heroicon-o-lock-closed class="w-6 h-6 text-primary-600" />
                <span class="text-xl font-semibold text-gray-900 dark:text-white">Konten Premium Terkunci</span>
            </div>
        </x-slot>

        <div class="flex flex-col items-center text-center space-y-6">
            <p class="text-lg text-gray-800 dark:text-gray-300 max-w-xl">
                Untuk melanjutkan dan membaca konten ini, Anda perlu memiliki langganan aktif.
                Dengan berlangganan, Anda mendapatkan akses penuh ke seluruh koleksi buku premium dan fitur eksklusif lainnya.
            </p>

            <div class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-4 py-2 rounded-full text-sm font-medium">
                Akses Premium Dimulai dari Rp 20.000 Saja!
            </div>

            <button class="button"><a href="{{ \App\Filament\Pages\PricingPage::getUrl() }}"wire:navigate>
                Lihat Paket Langganan Ini
            </a></button>
            

        </div>
    </x-filament::section>
</x-filament::page>
