<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin Dashboard</title>
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#1885C4">
        <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .text-alazhar { color: #1885C4; }
            .bg-alazhar { background-color: #1885C4; }
            .border-alazhar { border-color: #1885C4; }
            .focus-ring-alazhar:focus { --tw-ring-color: #1885C4 !important; border-color: #1885C4 !important; }
            .hover-bg-alazhar-dark:hover { background-color: #146a9d; }
            
            /* Override Breeze Indigo */
            .text-indigo-600 { color: #1885C4 !important; }
            .focus\:ring-indigo-500:focus { --tw-ring-color: #1885C4 !important; }
            .border-indigo-400 { border-color: #1885C4 !important; }
            .text-indigo-700 { color: #146a9d !important; }
            .bg-indigo-50 { background-color: #f0f9ff !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-800">
        <div class="min-h-screen bg-slate-50">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm border-b border-slate-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js').then(function(registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
                });
            }
        </script>
    </body>
</html>
