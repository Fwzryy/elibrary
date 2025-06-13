<x-filament-panels::page>
    <x-slot name="header">
        <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
            {{ static::$title }}
        </h1>
    </x-slot>

    <x-filament::section>
        <x-slot name="heading">
            Pilih Aksi Pengelolaan
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Tombol Kelola Buku --}}
            <a href="{{ \App\Filament\Resources\BookResource::getUrl('index') }}"
               class="filament-button fi-btn flex flex-col items-center justify-center gap-2 p-6 rounded-lg shadow-md bg-primary-600 text-white hover:bg-primary-700 transition duration-150 ease-in-out text-lg font-semibold"
               wire:navigate>
                <x-heroicon-o-book-open class="w-10 h-10" />
                Kelola Buku
            </a>

            {{-- Tombol Kelola Kategori --}}
            <a href="{{ \App\Filament\Resources\CategoryResource::getUrl('index') }}"
              class="filament-button fi-btn flex flex-col items-center justify-center gap-2 p-6 rounded-lg shadow-md bg-primary-600 text-white hover:bg-primary-500 transition duration-150 ease-in-out text-lg font-semibold"
              wire:navigate>
                <x-heroicon-o-tag class="w-10 h-10" />
                Kelola Kategori
            </a>
        </div>
    </x-filament::section>

</x-filament-panels::page>