@php
    $items = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'match' => 'dashboard'],
        ['label' => 'Riwayat', 'route' => 'history', 'match' => 'history'],
        ['label' => 'Pemberitahuan', 'route' => 'notifications', 'match' => 'notifications'],
        ['label' => 'Perangkat', 'route' => 'devices.index', 'match' => 'devices.*'],
    ];
@endphp

<div x-show="sidebarOpen" x-cloak x-transition.opacity class="fixed inset-0 z-30 bg-black/40 lg:hidden"
    @click="sidebarOpen = false" aria-hidden="true"></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 flex-col bg-sidebar text-white transition-transform lg:static lg:translate-x-0">
    <div class="px-6 py-6 text-2xl font-semibold tracking-tight">nafas.</div>

    <nav class="flex-1 space-y-1 px-3" aria-label="Menu utama">
        @foreach ($items as $item)
            @php $active = request()->routeIs($item['match']); @endphp
            <a href="{{ route($item['route']) }}" @if ($active) aria-current="page" @endif @class([
                'block rounded-lg px-3 py-2 text-sm font-medium transition',
                'bg-white/10 text-white' => $active,
                'text-white/70 hover:bg-white/5 hover:text-white' => !$active,
            ])>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</aside>