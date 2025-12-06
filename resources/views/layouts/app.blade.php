<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-base-200 min-h-screen">
        {{-- Sidebar Navigation --}}
        @include('layouts.sidebar')

        {{-- Main Content Area --}}
        <div class="lg:ms-64 transition-all duration-300">
            {{-- Content with top padding for fixed header --}}
            <main class="pt-16 min-h-screen">
                {{ $slot }}
            </main>
        </div>
        
        @stack('scripts')
    </body>
</html>
