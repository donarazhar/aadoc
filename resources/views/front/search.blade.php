@extends('layouts.front')

@section('title', 'Pencarian: ' . $query . ' - Al Azhar Apps')

@section('content')
<!-- Mobile Overlay -->
<div x-show="mobileMenuOpen" class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden" @click="mobileMenuOpen = false" x-transition.opacity style="display: none;"></div>

<!-- Sidebar -->
<div :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed z-50 inset-y-0 left-0 w-80 bg-white px-6 pb-10 overflow-y-auto transition-transform duration-300 lg:translate-x-0 lg:block lg:z-20 lg:top-[3.8125rem] lg:left-[max(0px,calc(50%-45rem))] lg:right-auto lg:w-[19.5rem] lg:bg-transparent lg:px-8 shadow-xl lg:shadow-none">
    
    <!-- Mobile Header inside Sidebar -->
    <div class="flex items-center justify-between pt-6 pb-4 lg:hidden">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('img/logo.png') }}" class="w-8 h-8 object-contain" alt="Logo Al Azhar">
            <span class="font-bold text-xl tracking-tight text-slate-900">Al Azhar Apps <span class="font-normal text-slate-500">Docs</span></span>
        </a>
        <button type="button" @click="mobileMenuOpen = false" class="text-slate-500 hover:text-slate-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Mobile Search & Login -->
    <div class="lg:hidden mt-4 mb-8">
        @auth
            <a href="{{ route('dashboard') }}" class="block text-slate-700 font-semibold hover:text-laravel mb-2">Admin Panel</a>
        @else
            <a href="{{ route('login') }}" class="block text-slate-700 font-semibold hover:text-laravel mb-2">Login</a>
        @endauth
        <hr class="my-6 border-slate-100">
    </div>

    <nav id="nav" class="lg:text-sm lg:leading-6 relative lg:pt-10 pb-8">
        <h5 class="mb-3 font-semibold text-slate-900 uppercase tracking-wider text-xs">Pencarian</h5>
        <ul class="space-y-3 border-l border-slate-100">
            <li><a href="{{ route('home') }}" class="block border-l -ml-px pl-4 border-transparent hover:border-slate-400 text-slate-700 hover:text-slate-900">&larr; Kembali ke Dokumen</a></li>
        </ul>
    </nav>
</div>

<div class="lg:pl-[19.5rem]">
    <main class="max-w-3xl mx-auto pt-8 lg:pt-10 px-4 sm:px-6 lg:px-8 xl:max-w-none xl:ml-0 xl:mr-[15.5rem] xl:pr-16 pb-24">
        
        <header id="header" class="relative z-20 mb-10">
            <div>
                <h1 class="inline-block text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">Hasil Pencarian</h1>
                <p class="text-slate-500 text-lg">Menampilkan hasil untuk: <span class="font-semibold text-laravel">"{{ $query }}"</span></p>
            </div>
        </header>

        <!-- Search Form Again -->
        <form action="{{ route('docs.search') }}" method="GET" class="relative max-w-2xl mb-12">
            <input type="text" name="q" value="{{ $query }}" class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-laravel focus:border-transparent text-slate-800 shadow-sm transition-shadow" required>
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <button type="submit" class="absolute right-2 top-1.5 bottom-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded px-4 transition-colors">
                Cari Lagi
            </button>
        </form>

        <div class="space-y-6">
            @if(count($documents) > 0)
                @foreach($documents as $doc)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center text-xs font-semibold tracking-wide text-laravel mb-2 uppercase">
                            <a href="{{ route('docs.category', $doc->category->slug) }}" class="hover:underline">{{ $doc->category->name }}</a>
                        </div>
                        <a href="{{ route('docs.show', [$doc->category->slug, $doc->slug]) }}" class="block">
                            <h2 class="text-xl font-bold text-slate-900 hover:text-laravel transition-colors mb-2">{{ $doc->title }}</h2>
                        </a>
                        <p class="text-slate-600 text-sm line-clamp-3">
                            {{ Str::limit(strip_tags($doc->content), 200) }}
                        </p>
                        <div class="mt-4 text-xs text-slate-400 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Diperbarui {{ $doc->updated_at->diffForHumans() }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-16 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-xl font-bold text-slate-900 mb-1">Tidak ada hasil ditemukan</h3>
                    <p class="text-slate-500">Kami tidak dapat menemukan dokumen yang cocok dengan kata kunci "{{ $query }}". Coba gunakan kata kunci lain.</p>
                </div>
            @endif
        </div>

    </main>
</div>
@endsection
