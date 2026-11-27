@props(['title' => null])

<header class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-6">
    <p class="text-sm font-medium text-gray-900">{{ $title }}</p>

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