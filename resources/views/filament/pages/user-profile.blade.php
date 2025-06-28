{{-- resources/views/filament/pages/user-profile.blade.php --}}

<x-filament-panels::page>
    <x-slot name="header">
        <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
            {{ static::$title }}
        </h1>
    </x-slot>

    <x-filament::section>
        <x-slot name="heading">
            Informasi Profil Saya
        </x-slot>

        <div class="flex flex-col items-center justify-center p-8 space-y-4"> 
            <div x-data="{ photoPreview: '{{ $this->user->profile_photo_path ? asset('storage/' . $this->user->profile_photo_path) : '' }}' }" class="relative group"> 
                <label for="newProfilePhoto" class="cursor-pointer">
                    @if ($this->user->profile_photo_path)
                        <img x-show="!photoPreview" src="{{ asset('storage/' . $this->user->profile_photo_path) }}"
                            alt="Foto Profil"
                            class=" rounded-full object-cover border-4 border-primary-500 shadow-lg transition duration-200" 
                            style="border-radius: 100%; width: 160px; height: 160px;" />
                    @endif
                    {{-- Tampilan Preview Foto Baru --}}
                    <img x-show="photoPreview" :src="photoPreview" alt="Preview"
                        class=" rounded-full object-cover border-4 border-primary-500 shadow-lg transition duration-200" style="border-radius: 100%; width: 160px; height: 160px;"/>

                    {{-- Placeholder jika tidak ada foto sama sekali --}}
                    @if (!$this->user->profile_photo_path && ! $newProfilePhoto)
                      <div class="w-32 h-32 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 text-6xl mb-4" style="border-radius: 100%; width: 160px; height: 160px;">
                        <x-filament::icon
                          icon="heroicon-o-user"
                          class="h-16 w-16"
                          />
                      </div>
                    @endif
                    
                    <div class="absolute inset-0 flex items-center justify-center rounded-full bg-black/50 opacity-0 group-hover:opacity-100 transition duration-200">
                        <x-heroicon-s-camera class="w-10 h-10 text-white" />
                    </div>
                </label>
                <input type="file" id="newProfilePhoto" wire:model.live="newProfilePhoto" class="sr-only"
                    x-on:change="
                      const reader = new FileReader();
                      reader.onload = (e) => { photoPreview = e.target.result; };
                      reader.readAsDataURL($event.target.files[0]);
                      " />
            </div>

            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $this->user->name }}</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400" style="margin-top: 2px">{{ $this->user->email }}</p>

            @if($this->user->library_id_number)
                <p class="text-md text-gray-500 dark:text-gray-400" style="margin-top: 2px">NIP: {{ $this->user->library_id_number }}</p>
            @endif

            @if($newProfilePhoto)
                <div class="flex flex-col items-center gap-2 mt-4">
                    <x-filament::button wire:click="saveProfilePhoto" wire:loading.attr="disabled" style="width: 200px">
                        <x-heroicon-o-check-circle class="w-20 h-4 mr-2" /> Simpan
                    </x-filament::button>
                    <x-filament::button wire:click="$set('newProfilePhoto', null)" wire:loading.attr="disabled" color="danger" outlined class="w-full max-w-xs">
                        <x-heroicon-o-x-mark class="w-20 h-4 mr-2" /> Batalkan
                    </x-filament::button>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-panels::page>