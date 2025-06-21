<div class="p-4 space-y-4">
    @if($activeSessions->isEmpty())
        <p class="text-gray-500 dark:text-gray-400 text-center">Tidak ada pengguna aktif saat ini.</p>
    @else
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($activeSessions as $session)
                <li class="py-2 flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $session->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $session->email }}</p>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Aktif {{ Carbon\Carbon::parse($session->last_activity)->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>