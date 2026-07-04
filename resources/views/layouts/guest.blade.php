<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login · Al-Azhar Apps</title>
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#1885C4">
        <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }

            /* Animated gradient background for left panel */
            .login-bg {
                background: linear-gradient(135deg, #0f4c81 0%, #1885C4 45%, #38b6ff 100%);
                background-size: 200% 200%;
                animation: gradientShift 8s ease infinite;
            }
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* Floating animation for decorative circles */
            .float-1 { animation: float1 6s ease-in-out infinite; }
            .float-2 { animation: float2 8s ease-in-out infinite; }
            .float-3 { animation: float3 7s ease-in-out infinite; }
            @keyframes float1 { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
            @keyframes float2 { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-14px); } }
            @keyframes float3 { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-18px); } }

            /* Pulse animation for logo ring */
            .logo-ring {
                animation: pulseRing 3s ease-in-out infinite;
            }
            @keyframes pulseRing {
                0%, 100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.2); }
                50% { box-shadow: 0 0 0 16px rgba(255,255,255,0); }
            }

            /* Google button hover effect */
            .btn-google {
                transition: all 0.25s ease;
                background: #ffffff;
            }
            .btn-google:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 28px -8px rgba(24, 133, 196, 0.35);
                border-color: #1885C4;
            }
            .btn-google:active {
                transform: translateY(0);
            }
        </style>
    </head>
    <body class="antialiased bg-slate-100 text-slate-800 min-h-screen">

        <div class="min-h-screen flex flex-col lg:flex-row">

            <!-- ===== LEFT PANEL: Branding ===== -->
            <div class="login-bg lg:w-1/2 xl:w-3/5 relative flex flex-col items-center justify-center p-10 md:p-16 overflow-hidden text-white">

                <!-- Decorative floating circles -->
                <div class="float-1 absolute top-[10%] left-[8%] w-36 h-36 bg-white/10 rounded-full blur-sm"></div>
                <div class="float-2 absolute bottom-[15%] right-[5%] w-56 h-56 bg-white/5 rounded-full blur-md"></div>
                <div class="float-3 absolute top-[40%] right-[15%] w-20 h-20 bg-blue-300/20 rounded-full blur-sm"></div>
                <div class="absolute bottom-[5%] left-[15%] w-24 h-24 bg-white/5 rounded-full blur"></div>
                <div class="absolute top-[-5%] right-[30%] w-48 h-48 bg-blue-700/30 rounded-full blur-xl"></div>

                <!-- Content -->
                <div class="relative z-10 text-center max-w-md">
                    <!-- Logo with pulsing ring -->
                    <div class="logo-ring w-28 h-28 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mx-auto mb-8 border border-white/30">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Al Azhar" class="w-20 h-20 object-contain drop-shadow-2xl">
                    </div>

                    <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight drop-shadow-lg">
                        Al-Azhar<br><span class="font-light opacity-90">Apps</span>
                    </h1>
                    <p class="text-blue-100 text-base md:text-lg font-medium leading-relaxed mb-10">
                        Portal dokumentasi resmi<br>untuk orang tua murid Al-Azhar
                    </p>

                    <!-- Feature badges -->
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/25 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Panduan Lengkap
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/25 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Aman & Terpercaya
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/25 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Selalu Terkini
                        </span>
                    </div>
                </div>

                <!-- Bottom copyright - only visible on large screens -->
                <p class="hidden lg:block absolute bottom-6 left-0 right-0 text-center text-xs text-blue-200/60 font-medium">
                    &copy; {{ date('Y') }} Yayasan Pesantren Islam Al-Azhar
                </p>
            </div>

            <!-- ===== RIGHT PANEL: Login Form ===== -->
            <div class="lg:w-1/2 xl:w-2/5 flex items-center justify-center p-6 sm:p-10 bg-white min-h-screen lg:min-h-0">
                <div class="w-full max-w-sm">

                    <!-- Mobile Logo (only shown on small screens) -->
                    <div class="flex flex-col items-center mb-8 lg:hidden">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Al Azhar" class="w-16 h-16 object-contain mb-3">
                        <h1 class="text-2xl font-bold text-slate-900">Al-Azhar Apps</h1>
                        <p class="text-sm text-slate-500">Portal Dokumentasi</p>
                    </div>

                    <!-- Login Header -->
                    <div class="mb-8">
                        <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Selamat Datang</h2>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Masuk menggunakan akun Gmail Anda yang telah terdaftar untuk mengakses dokumentasi Al-Azhar Apps.
                        </p>
                    </div>

                    <!-- The slot content (session status, errors, and google button) -->
                    {{ $slot }}

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-100"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="bg-white px-3 text-slate-400">Al-Azhar Apps · Admin Portal</span>
                        </div>
                    </div>

                    <!-- Info note -->
                    <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <svg class="w-5 h-5 text-alazhar flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-xs text-blue-700 leading-relaxed">
                            Hanya akun Gmail yang telah <strong>terdaftar</strong> yang dapat mengakses portal ini. Hubungi administrator jika belum memiliki akses.
                        </p>
                    </div>

                    <!-- Mobile copyright -->
                    <p class="lg:hidden mt-8 text-center text-xs text-slate-400">
                        &copy; {{ date('Y') }} Yayasan Pesantren Islam Al-Azhar
                    </p>
                </div>
            </div>

        </div>

        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js').then(function(registration) {
                        console.log('ServiceWorker registered:', registration.scope);
                    }, function(err) {
                        console.log('ServiceWorker registration failed:', err);
                    });
                });
            }
        </script>
    </body>
</html>
