<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Event Registration') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col">

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <a href="{{ route('events.index') }}" class="text-xl font-bold text-blue-600">
                    {{ config('app.name', 'Event Registration') }}
                </a>

                <nav class="space-x-4">
                    <a href="{{ route('events.index') }}" class="text-gray-700 hover:text-blue-600">
                        События
                    </a>
                </nav>
            </div>
        </header>

        <main class="flex-1 max-w-7xl mx-auto w-full px-4 py-6">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
