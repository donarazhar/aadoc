<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login · Al-Azhar Apps Docs</title>
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#1885C4">
        <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
            .btn-google { transition: all 0.2s ease; }
            .btn-google:hover { transform: translateY(-2px); box-shadow: 0 8px 24px -6px rgba(24,133,196,0.3); border-color: #1885C4; }
            .btn-google:active { transform: translateY(0); }
        </style>
    </head>
    <body class="antialiased min-h-screen bg-slate-50 flex items-center justify-center p-4">

        <div class="w-full max-w-sm">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <img src="{{ asset('img/logo.png') }}" alt="Logo Al Azhar" class="w-20 h-20 object-contain mx-auto mb-4 drop-shadow-sm">
                <h1 class="text-2xl font-bold text-slate-900">Al Azhar Apps <span class="font-normal text-slate-500">Docs</span></h1>
                <p class="text-sm text-slate-500 mt-1">Silahkan login untuk melihat Docs</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-8">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <p class="text-center text-xs text-slate-400 mt-6">
                &copy; {{ date('Y') }} Yayasan Pesantren Islam Al-Azhar
            </p>
        </div>

        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js');
                });
            }
        </script>
    </body>
</html>
