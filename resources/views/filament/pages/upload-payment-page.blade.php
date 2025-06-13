<x-filament::page>
    <x-filament::section>
      <style>
        .button {
          --bg: #000000;
          --hover-bg: #f6fbb9;
          --hover-text: #000;
          color: #ffffff;
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
            Unggah Bukti Pembayaran Anda
        </x-slot>

        <div class="space-y-6">
            <p class="text-gray-700 dark:text-gray-400">
                Silakan unggah bukti transfer pembayaran Anda untuk paket
                @if ($this->packageSlug)
                    <span class="font-bold text-primary-600">{{ str_replace('_', ' ', Str::title($this->packageSlug)) }}</span>
                @else
                    <span class="font-bold text-primary-600">Premium</span>
                @endif
                .
                Admin kami akan memverifikasi pembayaran Anda secepatnya.
            </p>

            <form wire:submit="submitPayment" class="space-y-6">
                {{ $this->form }}

                <button><input  class="button" type="submit" form="submitPayment"></button>
                  
                   
                
            </form>
        </div>
    </x-filament::section>
</x-filament::page>
