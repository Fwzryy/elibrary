
<header class="fi-header flex flex-col gap-y-6">
    <div class="fi-header-wrapper flex flex-col justify-between gap-y-4 md:flex-row md:items-center">
        <div class="fi-header-heading flex flex-col gap-y-1">
            <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                Dashboard Utama Saya 💻
            </h1>
            {{-- Pesan Selamat Datang Dinamis --}}
            @if($user)
                <p class="fi-header-subheading text-base text-gray-800 dark:text-white">
                    Selamat datang, {{ $user->name }}!
                    @if($is_admin)
                        <span class="text-primary-500 font-semibold ">(Administrator)</span>
                    @endif
                </p>
            @endif
        </div>
    </div>
</header