@props(['title' => null])

<header class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-6">
    <button type="button" class="mr-3 rounded-lg p-2 text-gray-600 hover:bg-gray-100 lg:hidden"
        @click="sidebarOpen = true" :aria-expanded="sidebarOpen.toString()" aria-label="Buka menu">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
    <div class="flex items-center">
        {{-- tombol hamburger di sini --}}
        <p class="text-sm font-medium text-gray-900">{{ $title }}</p>
    </div>

    <div class="flex items-center gap-4">
        <span class="hidden text-sm text-gray-500 sm:block">
            {{ now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}
        </span>

        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button type="button" aria-label="Menu akun"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-sidebar text-sm font-medium text-white">
                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(auth()->user()->name, 0, 1)) }}
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Keluar
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>