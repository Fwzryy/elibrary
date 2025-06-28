
<x-filament-widgets::widget>
    <x-filament::card class="p-4 flex items-center gap-4">
        {{-- Foto Profil --}}
        <div class="flex-shrink-0">
            @if ($user->profile_photo_path)
                <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                    alt="Foto Profil"
                    class="w-20 h-20 rounded-full object-cover border-2 border-primary-500 shadow-md" />
            @else
                <div class="w-20 h-20 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 text-4xl border-2 border-gray-300">
                    <x-heroicon-o-user class="h-10 w-10" />
                </div>
            @endif
        </div>

        {{-- Detail Profil --}}
        <div class="flex-grow">
            <h3 class="text-xl font-bold text-gray-900 mt-3 dark:text-white">Selamat Datang! {{ $user->name }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">{{ $user->email }}</p>
            @if ($user->library_id_number)
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 ">NIP: {{ $user->library_id_number }}</p>
            @endif
        </div>

    </x-filament::card>
</x-filament-widgets::widget>