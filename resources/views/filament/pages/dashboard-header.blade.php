

<style>
/* CSS */
.button-56 {
  align-items: center;
  background-color: #fee6e3;
  border: 2px solid #111;
  border-radius: 8px;
  box-sizing: border-box;
  color: #111;
  cursor: pointer;
  display: flex;
  font-family: Inter,sans-serif;
  font-size: 16px;
  height: 48px;
  justify-content: center;
  line-height: 24px;
  max-width: 100%;
  padding: 0 25px;
  position: relative;
  text-align: center;
  text-decoration: none;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-56:after {
  background-color: #eaff00;
  border-radius: 8px;
  content: "";
  display: block;
  height: 48px;
  left: 0;
  width: 100%;
  position: absolute;
  top: -2px;
  transform: translate(8px, 8px);
  transition: transform .2s ease-out;
  z-index: -1;
}

.button-56:hover:after {
  transform: translate(0, 0);
}

.button-56:active {
  background-color: #ffdeda;
  outline: 0;
}

.button-56:hover {
  outline: 0;
  
}

@media (min-width: 768px) {
  .button-56 {
    padding: 0 40px;
  }
}
</style>
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

        <div class="flex items-center gap-x-3">
            @if(Auth::check()) 
                <form action="{{ filament()->getCurrentPanel()->getLogoutUrl() }}" method="post" class="inline">
                    @csrf   
                    <button type="submit" class="button-56" role="button">Keluar 🏃🚪</button>
                </form>
            @endif
        </div>
    </div>
  </header>