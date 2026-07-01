@extends('layouts.front')

@section('title', ($document->title ?? $category->name) . ' - Al Azhar Apps Docs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row gap-8">
    
    <!-- Sidebar Navigation -->
    <aside class="w-full md:w-64 flex-shrink-0">
        <div class="sticky top-24 bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-2">Daftar Isi</h3>
            <nav class="space-y-1">
                @foreach($allCategories as $cat)
                    <div class="mb-4">
                        <a href="{{ route('docs.category', $cat->slug) }}" class="flex items-center px-2 py-2 text-sm font-medium rounded-md {{ $cat->id === $category->id ? 'bg-blue-50 text-blue-700' : 'text-gray-900 hover:bg-gray-50' }}">
                            {{ $cat->name }}
                        </a>
                        <!-- Sub menu (Documents in this category) -->
                        <div class="ml-4 mt-1 space-y-1 border-l-2 border-gray-100 pl-2">
                            @foreach($cat->documents as $doc)
                                <a href="{{ route('docs.show', [$cat->slug, $doc->slug]) }}" class="block px-2 py-1.5 text-sm rounded-md transition-colors {{ isset($document) && $document->id === $doc->id ? 'text-blue-600 font-medium bg-blue-50/50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                                    {{ $doc->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
    <article class="flex-1 min-w-0 bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
        @if(isset($document))
            <!-- Document Header -->
            <header class="mb-8 border-b border-gray-100 pb-8">
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('docs.category', $category->slug) }}" class="hover:text-blue-600">{{ $category->name }}</a>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
                    {{ $document->title }}
                </h1>
                
                <div class="flex items-center text-sm text-gray-500 gap-4">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Diperbarui {{ $document->updated_at->diffForHumans() }}
                    </span>
                </div>
            </header>

            <!-- Document Body (TinyMCE HTML output) -->
            <div class="prose prose-blue max-w-none">
                {!! $document->content !!}
            </div>
            
            <!-- Helpful block -->
            <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-between">
                <p class="text-sm text-gray-600">Apakah dokumentasi ini membantu?</p>
                <div class="flex gap-2">
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors">👍 Ya</button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors">👎 Tidak</button>
                </div>
            </div>

        @else
            <!-- Category Fallback if no document -->
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Kategori: {{ $category->name }}</h2>
                <p class="text-gray-500 mb-6">Belum ada dokumen yang dipublikasikan dalam kategori ini.</p>
            </div>
        @endif
    </article>

</div>
@endsection
