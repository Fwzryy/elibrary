<x-filament::widget>
    <x-filament::card>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            {{ static::$heading }}
        </h3>

        @if (count($latestBooks) > 0)
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($latestBooks as $book)
                    <li class="py-2">
                        <a href="#" class="font-medium text-primary-600 hover:underline dark:text-primary-500">
                            {{ $book['title'] }}
                        </a>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $book['author'] }}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 dark:text-gray-400">Belum ada buku terbaru yang tersedia.</p>
        @endif
    </x-filament::card>
</x-filament::widget>