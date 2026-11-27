<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $attributes->get('title') ? $attributes->get('title') . ' · ' : '' }}{{ config('app.name', 'nafas') }}
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans text-gray-900 antialiased">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
        <x-sidebar />

        <div class="flex min-w-0 flex-1 flex-col">
            <x-topbar :title="$attributes->get('title')" />

            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>