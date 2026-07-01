<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Al Azhar Apps Documentation')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
        }
        /* Prose Typography for TinyMCE HTML Output */
        .prose h1 { font-size: 2.25rem; font-weight: 800; margin-top: 2rem; margin-bottom: 1rem; color: #111827; }
        .prose h2 { font-size: 1.875rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; color: #111827; }
        .prose h3 { font-size: 1.5rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem; color: #111827; }
        .prose p { margin-top: 1.25em; margin-bottom: 1.25em; line-height: 1.75; color: #374151; }
        .prose a { color: #2563eb; text-decoration: underline; font-weight: 500; }
        .prose ul { list-style-type: disc; padding-left: 1.625em; margin-top: 1.25em; margin-bottom: 1.25em; }
        .prose ol { list-style-type: decimal; padding-left: 1.625em; margin-top: 1.25em; margin-bottom: 1.25em; }
        .prose li { margin-top: 0.5em; margin-bottom: 0.5em; }
        .prose img { border-radius: 0.5rem; max-width: 100%; height: auto; margin-top: 2em; margin-bottom: 2em; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
        .prose table { width: 100%; text-align: left; border-collapse: collapse; margin-top: 2em; margin-bottom: 2em; }
        .prose thead { border-bottom: 2px solid #d1d5db; }
        .prose th { font-weight: 600; padding: 0.75em; color: #111827; }
        .prose td { padding: 0.75em; border-bottom: 1px solid #e5e7eb; }
        .prose blockquote { border-left: 4px solid #e5e7eb; padding-left: 1em; font-style: italic; color: #4b5563; margin-top: 1.6em; margin-bottom: 1.6em; }
    </style>
</head>
<body class="antialiased text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <!-- Placeholder Logo -->
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl">
                            A
                        </div>
                        <span class="font-bold text-xl text-blue-900">Al Azhar <span class="font-light">Docs</span></span>
                    </a>
                </div>
                
                <div class="flex items-center gap-4">
                    <form action="{{ route('docs.search') }}" method="GET" class="relative hidden md:block">
                        <input type="text" name="q" placeholder="Cari dokumentasi..." class="w-64 pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-shadow shadow-sm hover:shadow-md" required>
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </form>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Admin Panel</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Login Admin</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Al Azhar Apps. Hak cipta dilindungi.
        </div>
    </footer>

</body>
</html>
