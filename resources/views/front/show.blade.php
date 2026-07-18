@extends('layouts.front')

@section('title', ($document->title ?? $category->name) . ' · Al-Azhar Apps Docs')

@section('content')

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar" :class="sidebarOpen ? 'open' : ''" class="lg:translate-x-0">

        {{-- Mobile Search --}}
        <div class="lg:hidden mb-6 relative">
            <form action="{{ route('docs.search') }}" method="GET">
                <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="q" placeholder="Cari dokumentasi..." class="search-input" required>
            </form>
        </div>

        {{-- Navigation --}}
        <nav>
            @foreach($allCategories as $cat)
                @php $isActiveCat = isset($category) && $category->id === $cat->id; @endphp
                <div class="mb-6" x-data="{ open: {{ $isActiveCat ? 'true' : 'true' }} }">
                    {{-- Category Heading --}}
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between mb-1.5 group focus:outline-none text-left">
                        <span class="sidebar-cat-heading group-hover:text-brand transition-colors">{{ $cat->name }}</span>
                        <svg class="w-3 h-3 text-slate-300 flex-shrink-0 transition-transform duration-200 mr-2"
                             :class="{'rotate-180': !open}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    {{-- Doc Links --}}
                    <ul x-show="open"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        class="space-y-0.5 border-l-2 border-slate-100 ml-2">
                        @forelse($cat->documents as $doc)
                            <li>
                                <a href="{{ route('docs.show', [$cat->slug, $doc->slug]) }}"
                                   class="sidebar-link {{ isset($document) && $document->id === $doc->id ? 'active' : '' }}">
                                    {{ $doc->title }}
                                </a>
                            </li>
                        @empty
                            <li>
                                <span class="sidebar-link italic text-slate-300">Belum ada artikel</span>
                            </li>
                        @endforelse
                    </ul>
                </div>
            @endforeach
        </nav>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="lg:pl-[17rem]">
        <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-24">

            @if(isset($document))
                {{-- Breadcrumb --}}
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-brand">{{ $category->name }}</span>
                </div>

                {{-- Document Title --}}
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mt-2 mb-8">
                    {{ $document->title }}
                </h1>

                {{-- Document Content --}}
                <div class="prose">
                    {!! $document->content !!}
                </div>

                {{-- Prev / Next Navigation --}}
                <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    @if(isset($prevDocument))
                        <a href="{{ route('docs.show', [$prevDocument->category->slug, $prevDocument->slug]) }}" class="group flex flex-col w-full sm:w-1/2 text-left p-4 rounded-xl border border-slate-200 hover:border-brand hover:shadow-sm transition-all">
                            <span class="text-xs text-slate-400 mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                Sebelumnya
                            </span>
                            <span class="font-semibold text-slate-800 group-hover:text-brand transition-colors line-clamp-1">{{ $prevDocument->title }}</span>
                        </a>
                    @else
                        <div class="w-full sm:w-1/2"></div>
                    @endif

                    @if(isset($nextDocument))
                        <a href="{{ route('docs.show', [$nextDocument->category->slug, $nextDocument->slug]) }}" class="group flex flex-col w-full sm:w-1/2 text-right p-4 rounded-xl border border-slate-200 hover:border-brand hover:shadow-sm transition-all text-right sm:items-end">
                            <span class="text-xs text-slate-400 mb-1 flex items-center justify-end gap-1">
                                Selanjutnya
                                <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                            <span class="font-semibold text-slate-800 group-hover:text-brand transition-colors line-clamp-1">{{ $nextDocument->title }}</span>
                        </a>
                    @else
                        <div class="w-full sm:w-1/2"></div>
                    @endif
                </div>

                {{-- Footer Meta --}}
                <div class="mt-8 flex items-center gap-2 text-xs text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Terakhir diperbarui {{ $document->updated_at->locale('id')->diffForHumans() }}
                </div>
            @else
                {{-- Category fallback --}}
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span>{{ $category->name }}</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-2 mb-6">
                    {{ $category->name }}
                </h1>
                <p class="text-slate-500">Pilih artikel di panel kiri untuk mulai membaca panduan mengenai kategori ini.</p>
            @endif
        </main>
    </div>

@endsection
