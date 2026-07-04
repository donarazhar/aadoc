<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin · Al-Azhar Apps Docs</title>
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
            #sidebar::-webkit-scrollbar { width: 4px; }
            #sidebar::-webkit-scrollbar-track { background: transparent; }
            #sidebar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        </style>
    </head>
    <body class="antialiased bg-slate-100 text-slate-800" x-data="{ sidebarOpen: false }">

        <!-- ===== SIDEBAR OVERLAY (Mobile) ===== -->
        <div id="sidebar-backdrop"
             x-show="sidebarOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 lg:hidden">
        </div>

        <!-- ===== SIDEBAR ===== -->
        <aside id="sidebar"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed top-0 left-0 h-screen w-64 bg-white border-r border-slate-100 shadow-xl z-40 flex flex-col overflow-y-auto transition-transform duration-300 ease-in-out lg:translate-x-0 lg:shadow-none">

            <!-- Sidebar Header / Logo -->
            <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100 flex-shrink-0">
                <img src="{{ asset('img/logo.png') }}" class="h-9 w-9 object-contain flex-shrink-0" alt="Logo Al Azhar">
                <div>
                    <p class="text-sm font-bold text-slate-900 leading-tight">Al-Azhar Apps <span class="font-normal text-slate-400">Docs</span></p>
                    <p class="text-xs text-slate-400 font-medium">Admin Portal</p>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 px-4 py-5 space-y-1">
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Menu Utama</p>

                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-alazhar font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-alazhar' }}">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-alazhar' : 'text-slate-400 group-hover:text-alazhar' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard</span>
                </a>

                @if(auth()->user()->isSuperadmin())
                    <a href="{{ route('admin.categories.index') }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-alazhar font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-alazhar' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.categories.*') ? 'text-alazhar' : 'text-slate-400 group-hover:text-alazhar' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Kategori</span>
                    </a>

                    <a href="{{ route('admin.documents.index') }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group {{ request()->routeIs('admin.documents.*') ? 'bg-blue-50 text-alazhar font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-alazhar' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.documents.*') ? 'text-alazhar' : 'text-slate-400 group-hover:text-alazhar' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Artikel / Dokumen</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-alazhar font-semibold' : 'text-slate-600 hover:bg-blue-50 hover:text-alazhar' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-alazhar' : 'text-slate-400 group-hover:text-alazhar' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>Pengguna</span>
                    </a>
                @endif

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Lainnya</p>
                    <a href="{{ route('home') }}" target="_blank"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-blue-50 hover:text-alazhar transition-all duration-200 group">
                        <svg class="w-5 h-5 flex-shrink-0 text-slate-400 group-hover:text-alazhar transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        <span>Lihat Portal Publik</span>
                    </a>
                </div>
            </nav>

            <!-- Sidebar Footer / User Profile -->
            <div class="flex-shrink-0 border-t border-slate-100 px-4 py-4">
                <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition-colors cursor-pointer group">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-alazhar to-blue-400 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden flex-1">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <!-- Dropdown menu -->
                    <div x-data="{ profileOpen: false }" class="relative">
                        <button @click.stop="profileOpen = !profileOpen" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-lg hover:bg-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                        </button>
                        <div x-show="profileOpen" @click.outside="profileOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute bottom-full right-0 mb-2 w-48 bg-white border border-slate-100 rounded-xl shadow-xl py-1 z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-alazhar transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Edit Profil
                            </a>
                            <hr class="my-1 border-slate-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT AREA ===== -->
        <div class="lg:pl-64 min-h-screen flex flex-col">

            <!-- ===== TOP HEADER BAR ===== -->
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur-md border-b border-slate-100 shadow-sm">
                <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>

                    <!-- Page Title (from $header slot) -->
                    <div class="flex-1 ml-3 lg:ml-0">
                        @isset($header)
                            {{ $header }}
                        @endisset
                    </div>

                    <!-- Right: Date & User Avatar -->
                    <div class="flex items-center gap-3">
                        <span class="hidden sm:block text-xs text-slate-400 font-medium">{{ now()->locale('id')->isoFormat('dddd, D MMM Y') }}</span>
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-alazhar to-blue-400 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- ===== PAGE CONTENT ===== -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>

            <!-- ===== FOOTER ===== -->
            <footer class="px-6 py-4 text-center text-xs text-slate-400 border-t border-slate-100">
                &copy; {{ date('Y') }} Al-Azhar Apps Admin Portal &mdash; YPI Al Azhar
            </footer>
        </div>

        @stack('scripts')
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
