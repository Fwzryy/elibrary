<div class="p-4 space-y-4">
    @if($activeSessions->isEmpty())
        <p class="text-gray-500 dark:text-gray-400 text-center">Tidak ada pengguna admin aktif saat ini.</p>
    @else
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($activeSessions as $session)
                <li class="py-2 flex justify-between items-center">
                    <div class="flex items-center gap-2"> 
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $session->name }}</p>
                        
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset">Aktif</span>
                    </div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $session->email }}</span> 
                    
                    <span class="text-xs text-gray-500 dark:text-gray-400">Terakhir: {{ Carbon\Carbon::parse($session->last_activity)->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>