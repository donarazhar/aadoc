<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Al Azhar Apps Documentation')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #fff; color: #334155; overflow-y: scroll; }
        .text-laravel { color: #1885C4; }
        .bg-laravel { background-color: #1885C4; }
        .border-laravel { border-color: #1885C4; }
        .focus-ring-laravel:focus { --tw-ring-color: #1885C4; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; border: 2px solid #fff; }

        /* Prose Typography */
        .prose { max-width: none; }
        .prose h1 { font-size: 2.25rem; font-weight: 800; color: #0f172a; margin-bottom: 2rem; letter-spacing: -0.025em; }
        .prose h2 { font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-top: 3rem; margin-bottom: 1rem; padding-bottom: 0.5rem; letter-spacing: -0.025em; }
        .prose h3 { font-size: 1.25rem; font-weight: 600; color: #0f172a; margin-top: 2rem; margin-bottom: 0.75rem; }
        .prose p { margin-top: 1.25em; margin-bottom: 1.25em; line-height: 1.75; color: #475569; }
        .prose a { color: #1885C4; text-decoration: none; font-weight: 600; }
        .prose a:hover { text-decoration: underline; }
        .prose ul { list-style-type: disc; padding-left: 1.625em; margin-top: 1.25em; margin-bottom: 1.25em; color: #475569; }
        .prose ol { list-style-type: decimal; padding-left: 1.625em; margin-top: 1.25em; margin-bottom: 1.25em; color: #475569; }
        .prose li { margin-top: 0.5em; margin-bottom: 0.5em; }
        .prose code { background-color: #f1f5f9; padding: 0.2em 0.4em; border-radius: 0.375rem; font-size: 0.875em; color: #1885C4; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
        .prose pre { background-color: #0f172a; color: #f8fafc; padding: 1.25rem 1.5rem; border-radius: 0.75rem; overflow-x: auto; margin-top: 1.5em; margin-bottom: 1.5em; font-size: 0.875em; line-height: 1.7142857; }
        .prose pre code { background-color: transparent; color: inherit; padding: 0; font-size: inherit; }
        .prose img { border-radius: 0.5rem; max-width: 100%; height: auto; margin-top: 2em; margin-bottom: 2em; box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); }
        .prose blockquote { border-left: 4px solid #1885C4; padding-left: 1rem; font-style: normal; color: #334155; background-color: #f0f9ff; padding-top: 0.75rem; padding-bottom: 0.75rem; padding-right: 1rem; border-radius: 0 0.5rem 0.5rem 0; margin-top: 1.6em; margin-bottom: 1.6em; }
    </style>
</head>
<body class="antialiased" x-data="{ mobileMenuOpen: false }" :class="{ 'overflow-hidden': mobileMenuOpen }">

    <!-- Top Navbar -->
    <div class="sticky top-0 z-50 w-full backdrop-blur flex-none transition-colors duration-500 border-b border-slate-900/10 bg-white/95 supports-backdrop-blur:bg-white/60">
        <div class="max-w-[90rem] mx-auto">
            <div class="py-4 border-b border-slate-900/10 lg:px-8 lg:border-0 mx-4 lg:mx-0">
                <div class="relative flex items-center">
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="mr-4 flex items-center justify-center w-10 h-10 rounded-md text-slate-500 hover:text-slate-600 hover:bg-slate-100 lg:hidden focus:outline-none focus:ring-2 focus:ring-laravel">
                        <span class="sr-only">Toggle main menu</span>
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg x-show="mobileMenuOpen" class="w-6 h-6" style="display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <a href="{{ route('home') }}" class="mr-3 flex-none overflow-hidden md:w-auto flex items-center gap-2">
                        <img src="{{ asset('img/logo.png') }}" class="w-8 h-8 object-contain" alt="Logo Al Azhar">
                        <span class="sr-only">Al Azhar Apps Docs home page</span>
                        <span class="font-bold text-xl tracking-tight text-slate-900">Al Azhar Apps <span class="font-normal text-slate-500 hidden sm:inline">Docs</span></span>
                    </a>
                    <div class="relative hidden lg:flex items-center ml-auto">
                        <nav class="text-sm leading-6 font-semibold text-slate-700">
                            <ul class="flex space-x-8">
                                <li>
                                    <form action="{{ route('docs.search') }}" method="GET" class="relative group">
                                        <input type="text" name="q" placeholder="Search docs..." class="w-64 pl-10 pr-4 py-1.5 bg-slate-50 border border-slate-200 rounded-md focus:bg-white focus:ring-1 focus:ring-laravel focus:border-laravel text-sm transition-colors text-slate-900 placeholder-slate-400" required>
                                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5 group-focus-within:text-laravel" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </form>
                                </li>
                                <li>
                                    @auth
                                        <a href="{{ route('dashboard') }}" class="hover:text-laravel transition-colors flex items-center pt-1.5">Admin Panel</a>
                                    @else
                                        <a href="{{ route('login') }}" class="hover:text-laravel transition-colors flex items-center pt-1.5">Login</a>
                                    @endauth
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div class="overflow-hidden">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 md:px-8">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
