@extends('layouts.front')

@section('title', 'Pusat Bantuan & Dokumentasi · Al-Azhar Apps')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">

    {{-- ===== HERO ===== --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-[#0f4c81] via-[#1885C4] to-[#38b6ff] rounded-2xl mt-6 mb-12 px-8 py-16 text-white text-center">
        {{-- Decorative circles --}}
        <div class="absolute -top-16 -left-16 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -right-10 w-80 h-80 bg-blue-300/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 max-w-2xl mx-auto">
            <span class="inline-block bg-white/15 border border-white/20 text-white text-xs font-semibold uppercase tracking-widest px-3 py-1 rounded-full mb-5">
                Pusat Bantuan
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 leading-tight tracking-tight">
                Al-Azhar Apps<br class="sm:hidden"> Dokumentasi
            </h1>
            <p class="text-blue-100 text-base sm:text-lg mb-10 max-w-xl mx-auto">
                Panduan lengkap untuk semua fitur aplikasi Al-Azhar Apps. Temukan jawaban, tutorial, dan referensi yang Anda butuhkan.
            </p>

            {{-- Search Bar --}}
            <form action="{{ route('docs.search') }}" method="GET"
                  class="flex items-center max-w-lg mx-auto bg-white rounded-xl shadow-lg overflow-hidden ring-1 ring-white/30">
                <div class="flex-1 relative">
                    <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="q" placeholder="Cari panduan, fitur, atau tutorial…"
                           class="w-full pl-12 pr-4 py-3.5 text-slate-800 text-sm placeholder-slate-400 bg-transparent outline-none" required>
                </div>
                <button type="submit" class="bg-brand hover:bg-brand-dark transition-colors text-white font-semibold text-sm px-6 py-3.5 flex-shrink-0 flex items-center gap-2">
                    Cari
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </form>
        </div>
    </div>

    {{-- ===== CATEGORIES GRID ===== --}}
    <div class="max-w-6xl mx-auto mb-16">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-900">Jelajahi Kategori</h2>
            <span class="text-sm text-slate-400">{{ $categories->count() }} kategori tersedia</span>
        </div>

        @if($categories->isEmpty())
            <div class="text-center py-20 border border-dashed border-slate-200 rounded-2xl">
                <svg class="w-14 h-14 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path></svg>
                <p class="text-slate-400">Belum ada kategori tersedia.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('docs.category', $category->slug) }}"
                       class="group flex items-start gap-4 bg-white border border-slate-100 rounded-xl p-5 hover:border-brand/30 hover:shadow-md transition-all duration-200">
                        {{-- Icon --}}
                        <div class="flex-shrink-0 w-11 h-11 rounded-lg bg-blue-50 text-brand flex items-center justify-center group-hover:bg-brand group-hover:text-white transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        {{-- Text --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="text-sm font-bold text-slate-900 group-hover:text-brand transition-colors leading-snug">
                                    {{ $category->name }}
                                </h3>
                                <svg class="w-4 h-4 text-slate-300 flex-shrink-0 mt-0.5 group-hover:text-brand group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                {{ $category->description ?? 'Dokumentasi dan panduan seputar ' . $category->name . '.' }}
                            </p>
                            <span class="inline-block mt-2 text-xs font-medium text-brand">
                                {{ $category->documents_count ?? 0 }} artikel
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
