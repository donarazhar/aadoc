<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin Dashboard - Login</title>
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <style>
        .text-alazhar { color: #1885C4; }
        .bg-alazhar { background-color: #1885C4; }
        .border-alazhar { border-color: #1885C4; }
        .focus-ring-alazhar:focus { --tw-ring-color: #1885C4; border-color: #1885C4; }
        .hover-bg-alazhar-dark:hover { background-color: #146a9d; }
    </style>
    <body class="font-sans text-slate-900 antialiased bg-slate-50 relative overflow-hidden">
        <!-- Subtle Background Decoration -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-[30%] -right-[10%] w-[70%] h-[70%] rounded-full bg-[#1885C4] opacity-5 blur-[100px]"></div>
            <div class="absolute -bottom-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-[#1885C4] opacity-10 blur-[100px]"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo Al Azhar" class="w-24 h-24 object-contain mx-auto mb-4 drop-shadow-sm">
                </a>
                <h1 class="text-2xl font-bold text-slate-800">Admin Portal</h1>
                <p class="text-sm text-slate-500 mt-1">Masuk untuk mengelola dokumentasi</p>
            </div>

            <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-xl shadow-slate-200/50 sm:rounded-2xl border border-slate-100">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} Yayasan Pesantren Islam Al-Azhar
            </div>
        </div>
    </body>
</html>
