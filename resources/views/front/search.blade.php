@extends('layouts.front')

@section('title', 'Hasil Pencarian: "' . $query . '" · Al-Azhar Apps Docs')

@section('content')

    <aside id="sidebar" :class="sidebarOpen ? 'open' : ''" class="lg:translate-x-0">
        <nav>
            <div class="mb-6">
                <span class="sidebar-cat-heading">Navigasi</span>
                <ul class="space-y-0.5 border-l-2 border-slate-100 ml-2 mt-1.5">
                    <li>
                        <a href="{{ route('home') }}" class="sidebar-link flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Beranda
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>

    <div class="lg:pl-[17rem]">
        <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-24">

            {{-- Header --}}
            <div class="breadcrumb mb-4">
                <a href="{{ route('home') }}">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span>Pencarian</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-1">Hasil Pencarian</h1>
            <p class="text-slate-500 mb-8 text-sm">
                Menampilkan {{ count($documents) }} hasil untuk kata kunci:
                <span class="font-semibold text-brand">"{{ $query }}"</span>
            </p>

            {{-- Search again --}}
            <form action="{{ route('docs.search') }}" method="GET"
                  class="flex items-center mb-10 bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                <div class="flex-1 relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="q" value="{{ $query }}"
                           class="w-full pl-11 pr-4 py-3 text-slate-800 text-sm bg-transparent outline-none placeholder-slate-400" required>
                </div>
                <button type="submit"
                        class="bg-brand text-white font-semibold text-sm px-5 py-3 flex-shrink-0 hover:opacity-90 transition-opacity">
                    Cari
                </button>
            </form>

            {{-- Results --}}
            @if(count($documents) > 0)
                <div class="space-y-4">
                    @foreach($documents as $doc)
                        <a href="{{ route('docs.show', [$doc->category->slug, $doc->slug]) }}"
                           class="group flex flex-col gap-1.5 bg-white border border-slate-100 rounded-xl p-5 hover:border-brand/30 hover:shadow-md transition-all duration-200">
                            <span class="text-xs font-semibold text-brand uppercase tracking-wide">
                                {{ $doc->category->name }}
                            </span>
                            <h2 class="text-base font-bold text-slate-900 group-hover:text-brand transition-colors">
                                {{ $doc->title }}
                            </h2>
                            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($doc->content), 180) }}
                            </p>
                            <div class="flex items-center gap-1.5 text-xs text-slate-400 mt-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Diperbarui {{ $doc->updated_at->diffForHumans() }}
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 border border-dashed border-slate-200 rounded-2xl">
                    <svg class="w-14 h-14 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-lg font-bold text-slate-700 mb-2">Tidak ada hasil ditemukan</h3>
                    <p class="text-slate-400 text-sm max-w-xs mx-auto">Coba gunakan kata kunci yang lebih umum atau periksa ejaan.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-6 text-sm font-medium text-brand hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            @endif

        </main>
    </div>

@endsection
