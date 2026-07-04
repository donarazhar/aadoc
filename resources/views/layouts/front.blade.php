<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Al-Azhar Apps Docs')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1885C4">
    <meta name="description" content="Portal dokumentasi resmi Al-Azhar Apps. Temukan panduan lengkap untuk semua fitur aplikasi.">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background-color: #ffffff;
            color: #334155;
            overflow-y: scroll;
        }

        /* ===== VARIABLES ===== */
        :root {
            --brand: #1885C4;
            --brand-dark: #0f6ea8;
            --brand-light: #e0f2fe;
        }

        /* ===== CUSTOM SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }

        /* ===== BRAND HELPERS ===== */
        .text-brand { color: var(--brand); }
        .bg-brand { background-color: var(--brand); }
        .border-brand { border-color: var(--brand); }
        .ring-brand { --tw-ring-color: var(--brand); }

        /* ===== NAVBAR ===== */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            width: 100%;
            height: 4rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* ===== SIDEBAR ===== */
        #sidebar {
            position: fixed;
            top: 4rem;
            bottom: 0;
            left: 0;
            width: 17rem;
            overflow-y: auto;
            border-right: 1px solid #f1f5f9;
            padding: 1.5rem 1.25rem 3rem;
            background: #fafafa;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 40;
        }
        #sidebar.open { transform: translateX(0); }
        @media (min-width: 1024px) {
            #sidebar { transform: translateX(0); }
        }
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-thumb { background-color: #e2e8f0; border-radius: 4px; }

        /* ===== SIDEBAR NAV LINKS ===== */
        .sidebar-link {
            display: block;
            border-left: 2px solid transparent;
            margin-left: -2px;
            padding: 0.3rem 0.75rem;
            font-size: 0.875rem;
            color: #64748b;
            transition: color 0.15s, border-color 0.15s;
            line-height: 1.5;
        }
        .sidebar-link:hover { color: #0f172a; border-left-color: #cbd5e1; }
        .sidebar-link.active { color: var(--brand); border-left-color: var(--brand); font-weight: 600; }

        /* ===== PROSE CONTENT ===== */
        .prose { max-width: none; line-height: 1.8; }
        .prose h1 { font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; letter-spacing: -0.025em; line-height: 1.2; }
        .prose h2 { font-size: 1.375rem; font-weight: 700; color: #0f172a; margin-top: 2.5rem; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f1f5f9; letter-spacing: -0.015em; }
        .prose h3 { font-size: 1.125rem; font-weight: 600; color: #1e293b; margin-top: 1.75rem; margin-bottom: 0.5rem; }
        .prose h4 { font-size: 1rem; font-weight: 600; color: #334155; margin-top: 1.5rem; margin-bottom: 0.5rem; }
        .prose p { margin-top: 1em; margin-bottom: 1em; color: #475569; }
        .prose strong { color: #1e293b; font-weight: 600; }
        .prose a { color: var(--brand); text-decoration: none; font-weight: 500; }
        .prose a:hover { text-decoration: underline; }
        .prose ul, .prose ol { padding-left: 1.5rem; margin-top: 1em; margin-bottom: 1em; color: #475569; }
        .prose ul { list-style-type: disc; }
        .prose ol { list-style-type: decimal; }
        .prose li { margin-top: 0.4em; margin-bottom: 0.4em; }
        .prose hr { border-color: #f1f5f9; margin: 2rem 0; }
        .prose code { background: #f0f9ff; border: 1px solid #bae6fd; padding: 0.15em 0.4em; border-radius: 0.3rem; font-size: 0.85em; color: #0369a1; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; }
        .prose pre { background: #0f172a; color: #f8fafc; padding: 1.25rem 1.5rem; border-radius: 0.75rem; overflow-x: auto; margin: 1.5em 0; font-size: 0.875em; line-height: 1.7; }
        .prose pre code { background: transparent; color: inherit; padding: 0; border: none; font-size: inherit; }
        .prose blockquote { border-left: 3px solid var(--brand); padding: 0.75rem 1rem; background: #f0f9ff; border-radius: 0 0.5rem 0.5rem 0; margin: 1.5em 0; color: #334155; }
        .prose blockquote p { margin: 0; }
        .prose img { border-radius: 0.75rem; max-width: 100%; height: auto; margin: 1.75em auto; display: block; box-shadow: 0 4px 20px -4px rgba(0,0,0,0.12); }
        .prose table { width: 100%; border-collapse: collapse; margin: 1.5em 0; font-size: 0.9em; }
        .prose th { background: #f8fafc; padding: 0.6rem 1rem; border: 1px solid #e2e8f0; font-weight: 600; text-align: left; color: #334155; }
        .prose td { padding: 0.6rem 1rem; border: 1px solid #e2e8f0; color: #475569; }
        .prose tr:hover td { background: #fafafa; }

        /* Image wrapper from TinyMCE */
        .prose div[style*="max-width: 350px"],
        .prose div[style*="width: 120px"] {
            border: none !important; box-shadow: none !important; background: transparent !important;
        }
        .prose div[style*="max-width: 350px"] img,
        .prose div[style*="width: 120px"] img {
            margin: 0 !important; width: 100% !important; height: auto !important;
            object-fit: contain !important; border-radius: 1rem !important;
        }

        /* ===== SEARCH INPUT ===== */
        .search-input {
            width: 100%;
            padding: 0.5rem 0.75rem 0.5rem 2.25rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            background: #f8fafc;
            color: #334155;
            transition: all 0.2s;
            outline: none;
        }
        .search-input:focus {
            border-color: var(--brand);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(24,133,196,0.12);
        }
        .search-input::placeholder { color: #94a3b8; }

        /* ===== BREADCRUMB ===== */
        .breadcrumb { display: flex; align-items: center; gap: 0.375rem; font-size: 0.75rem; color: #94a3b8; font-weight: 500; margin-bottom: 0.5rem; }
        .breadcrumb a { color: var(--brand); }
        .breadcrumb a:hover { text-decoration: underline; }

        /* ===== PAGINATION NAV ===== */
        .doc-nav-btn {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.75rem 1rem; border: 1px solid #e2e8f0;
            border-radius: 0.75rem; font-size: 0.875rem; font-weight: 500;
            color: #475569; transition: all 0.2s; text-decoration: none;
            background: #fff;
        }
        .doc-nav-btn:hover {
            border-color: var(--brand); color: var(--brand);
            background: #f0f9ff;
        }

        /* ===== CATEGORY HEADING in sidebar ===== */
        .sidebar-cat-heading {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            margin-bottom: 0.5rem;
            padding: 0 0.75rem;
        }
    </style>
</head>
<body class="antialiased" x-data="{ sidebarOpen: false }" :class="{ 'overflow-hidden lg:overflow-auto': sidebarOpen }">

    <!-- ===== NAVBAR ===== -->
    <header class="navbar">
        <div class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4">

            <!-- Hamburger (Mobile) -->
            <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden flex items-center justify-center w-9 h-9 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors focus:outline-none"
                    aria-label="Toggle menu">
                <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="sidebarOpen" style="display:none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0">
                <img src="{{ asset('img/logo.png') }}" class="w-8 h-8 object-contain" alt="Logo Al Azhar">
                <span class="font-bold text-[17px] text-slate-900 leading-none">
                    Al Azhar Apps <span class="font-normal text-slate-400">Docs</span>
                </span>
            </a>

            <!-- Desktop Search -->
            <div class="hidden lg:flex flex-1 max-w-xs ml-6 relative">
                <form action="{{ route('docs.search') }}" method="GET">
                    <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="q" placeholder="Cari dokumentasi..." class="search-input" required>
                </form>
            </div>

            <!-- Right: User / Login -->
            <div class="flex items-center gap-3 ml-auto">
                @auth
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open"
                                class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100 transition-colors focus:outline-none">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:block">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             style="display:none;"
                             class="absolute right-0 top-full mt-1.5 w-52 bg-white rounded-xl shadow-xl border border-slate-100 py-1.5 z-50">
                            <div class="px-4 py-2 border-b border-slate-100 mb-1">
                                <p class="text-xs font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>
                            @if(auth()->user()->isSuperadmin())
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    Dashboard Admin
                                </a>
                            @endif
                            <hr class="my-1 border-slate-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-brand text-white text-sm font-semibold rounded-lg hover:opacity-90 transition-opacity">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         style="display:none;"
         class="fixed inset-0 bg-black/40 backdrop-blur-sm z-30 lg:hidden">
    </div>

    <!-- ===== PAGE WRAPPER ===== -->
    <div class="w-full max-w-screen-2xl mx-auto">
        @yield('content')
    </div>

    <!-- ===== FOOTER ===== -->
    <footer class="border-t border-slate-100 mt-20 py-8 text-center text-xs text-slate-400">
        <p>&copy; {{ date('Y') }} Yayasan Pesantren Islam Al-Azhar &mdash; Al-Azhar Apps Docs</p>
    </footer>

    @stack('scripts')
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
</body>
</html>
