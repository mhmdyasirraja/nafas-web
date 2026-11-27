@props(['level' => null])

@php
    use App\Enums\AlertLevel;

    $style = match ($level) {
        AlertLevel::Aman => [
            'label' => 'Aman',
            'badge' => 'bg-status-aman/10 text-status-aman',
            'dot' => 'bg-status-aman',
        ],
        AlertLevel::Waspada => [
            'label' => 'Waspada',
            'badge' => 'bg-status-waspada/10 text-status-waspada',
            'dot' => 'bg-status-waspada',
        ],
        AlertLevel::Bahaya => [
            'label' => 'Bahaya',
            'badge' => 'bg-status-bahaya/10 text-status-bahaya',
            'dot' => 'bg-status-bahaya',
        ],
        default => [
            'label' => 'Tidak ada data',
            'badge' => 'bg-gray-100 text-gray-600',
            'dot' => 'bg-gray-400',
        ],
    };
@endphp

<span {{ $attributes->class(['inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium', $style['badge']]) }}>
    <span class="h-1.5 w-1.5 rounded-full {{ $style['dot'] }}" aria-hidden="true"></span>
    {{ $style['label'] }}
</span>