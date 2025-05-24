<x-filament::page>
    <x-filament::section>
<style>
        .button {
          --bg: #9849ff;
          --hover-bg: #c490ff;
          --hover-text: #000;
          color: #ffeaf9;
          cursor: pointer;
          border: 1px solid var(--bg);
          border-radius: 4px;
          padding: 0.8em 2em;
          background: var(--bg);
          transition: 0.2s;
          font-weight: 600
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
          🎉 Langganan Sekarang & Nikmati Semua Fitur Premium!
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card Paket Gratis --}}
            <div class="filament-card p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md border-2 border-dashed border-gray-300 dark:border-gray-600 relative">
              {{-- Badge --}}
              <span class="absolute top-0 right-0 mt-2 mr-2 bg-gray-200 text-gray-900 dark:bg-gray-900 dark:text-gray-200 text-xs font-semibold px-2 py-1 rounded-full">Tidak Perlu Biaya ❌</span>

              <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-2 mb-1">Paket Gratis</h2>

                <p class="text-base text-gray-600 dark:text-gray-400 mb-4">Mulai Tanpa Komitmen</p>
                
                <hr class="border-t border-gray-200 dark:border-gray-700 my-4">
                <p class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">Rp 0
                  <span class="text-lg font-normal text-gray-500 dark:text-gray-400">/ Selamanya</span>
                </p>
                <ul class="text-gray-700 dark:text-gray-400 mb-6 space-y-3 text-left">
                  <li class="flex items-center gap-2">
                      <x-heroicon-s-check-circle class="w-5 h-5 text-green-500 flex-shrink-0" />
                      <span>Akses terbatas ke koleksi buku gratis</span>
                  </li>
                  <li class="flex items-center gap-2 text-red-500 dark:text-red-400 opacity-75">
                      <x-heroicon-s-x-circle class="w-5 h-5 flex-shrink-0" />
                      <span>Tidak termasuk buku premium</span>
                  </li>
                  <li class="flex items-center gap-2 text-red-500 dark:text-red-400 opacity-75">
                      <x-heroicon-s-x-circle class="w-5 h-5 flex-shrink-0" />
                      <span>Tanpa dukungan prioritas</span>
                  </li>
                </ul>
                <hr class="border-t border-gray-200 dark:border-gray-700 my-4">
                {{-- Deskripsi  --}}
                <p class="text-sm text-gray-500 dark:text-gray-400 italic mb-6">
                    💡 Ideal bagi pengguna baru yang ingin mencoba layanan
                </p>

                <a href="{{ \App\Filament\Resources\BookResource::getUrl('index') }}"
                  class="filament-button inline-flex items-center justify-center gap-1.5 rounded-lg px-5 py-3 font-semibold outline-none transition duration-75 text-white bg-gray-500 cursor-not-allowed "
                  disabled>
                    👉 Paket Saat Ini
                </a>
            </div>

            {{-- Card Paket Premium 30 Hari --}}
            <div class="filament-card p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg border-2 border-primary-600 relative">
              {{-- Badge --}}
              <span class="absolute top-0 right-0 mt-2 mr-2 bg-gray-200 text-gray-900 dark:bg-gray-900 dark:text-gray-200 text-xs font-semibold px-2 py-1 rounded-full">Paling Populer ⭐</span>

                <h2 class="text-2xl font-bold text-primary-600 mt-2 mb-1">Premium 30 Hari</h2>
                <p class="text-base text-gray-600 dark:text-gray-400 mb-4">Akses Penuh Selama Sebulan</p>

                <hr class="border-t border-gray-200 dark:border-gray-700 my-4">

              <p class="text-4xl font-extrabold text-primary-600 mb-4">Rp 20.000
                <span class="text-lg font-normal text-gray-500 dark:text-gray-400">/ 30 Hari</span>
              </p>

                <ul class="text-gray-700 dark:text-gray-400 mb-6 space-y-3 text-left">
                  <li class="flex items-center gap-2">
                      <x-heroicon-s-check-circle class="w-5 h-5 text-green-500 flex-shrink-0" />
                      <span>Akses penuh ke seluruh buku premium</span>
                  </li>
                  <li class="flex items-center gap-2">
                      <x-heroicon-s-check-circle class="w-5 h-5 text-green-500 flex-shrink-0" />
                      <span>Dukungan Pelanggan Prioritas</span>
                  </li>
                  <li class="flex items-center gap-2">
                      <x-heroicon-s-check-circle class="w-5 h-5 text-green-500 flex-shrink-0" />
                      <span>Bebas baca selama masa langganan</span>
                  </li>
                </ul>

                <hr class="border-t border-gray-200 dark:border-gray-700 my-4">
                
                {{-- Deskripsi --}}
                  <p class="text-sm text-gray-500 dark:text-gray-400 italic mb-6">
                      ✨ Rekomendasi untuk pengalaman optimal
                  </p>
                  <br>
                {{-- Tombol untuk mengarahkan ke UploadPaymentPage dengan parameter paket --}}
                <button class="button">
                  <a href="{{ \App\Filament\Pages\UploadPaymentPage::getUrl(['package' => 'premium_30_days', 'amount' => 20000]) }}"wire:navigate>
                    Pilih Paket Langganan Ini 👆
                </a></button>

            </div>

            {{-- Card Paket Premium 90 Hari --}}
           <div class="filament-card p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg border-2 border-primary-600 relative">
             {{-- Badge --}}
              <span class="absolute top-0 right-0 mt-2 mr-2 bg-gray-200 text-gray-900 dark:bg-gray-900 dark:text-gray-200 text-xs font-semibold px-2 py-1 rounded-full">Hemat Lebih Banyak 💰</span>
                <h2 class="text-2xl font-bold text-primary-600 mt-2 mb-1">Premium 90 Hari</h2>
                <p class="text-base text-gray-600 dark:text-gray-400 mb-4">Diskon Khusus untuk Jangka Panjang</p>

                <hr class="border-t border-gray-200 dark:border-gray-700 my-4">

                <p class="text-4xl font-extrabold text-primary-600 mb-4">Rp 55.000
                  <span class="text-lg font-normal text-gray-500 dark:text-gray-400">/ 90 Hari</span>
                </p>
                
                <ul class="text-gray-700 dark:text-gray-400 mb-6 space-y-3 text-left">
                    <li class="flex items-center gap-2">
                        <x-heroicon-s-check-circle class="w-5 h-5 text-green-500 flex-shrink-0" />
                        <span>Akses penuh ke seluruh buku premium</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <x-heroicon-s-check-circle class="w-5 h-5 text-green-500 flex-shrink-0" />
                        <span>Dukungan Pelanggan Prioritas</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <x-heroicon-s-check-circle class="w-5 h-5 text-green-500 flex-shrink-0" />
                        <span>Diskon Khusus & Penawaran Eksklusif</span>
                    </li>
                </ul>

                <hr class="border-t border-gray-200 dark:border-gray-700 my-4">

                {{-- Deskripsi --}}
                  <p class="text-sm text-gray-500 dark:text-gray-400 italic mb-6">
                      🌟 Pilihan terbaik untuk nilai dan keuntungan
                  </p>
                  <br>
                {{-- Tombol untuk mengarahkan ke UploadPaymentPage dengan parameter paket --}}
                <button class="button">
                <a href="{{ \App\Filament\Pages\UploadPaymentPage::getUrl(['package' => 'premium_90_days', 'amount' => 55000]) }}"wire:navigate>
                    Pilih Paket Langganan Ini 👆
                </a></button>
            </div>
        </div>
    </x-filament::section>
</x-filament::page>