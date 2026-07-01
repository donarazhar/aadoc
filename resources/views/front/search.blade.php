@extends('layouts.front')

@section('title', 'Pencarian: ' . $query . ' - Al Azhar Apps')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Hasil Pencarian</h1>
        <p class="text-gray-600">Menampilkan hasil pencarian untuk kata kunci: <span class="font-semibold text-blue-600">"{{ $query }}"</span></p>
    </div>

    <!-- Search Form Again -->
    <form action="{{ route('docs.search') }}" method="GET" class="relative max-w-2xl mb-12">
        <input type="text" name="q" value="{{ $query }}" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 shadow-sm" required>
        <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <button type="submit" class="absolute right-2 top-1.5 bottom-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg px-4 transition-colors">
            Cari Lagi
        </button>
    </form>

    <div class="space-y-6">
        @if(count($documents) > 0)
            @foreach($documents as $doc)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center text-xs font-medium text-blue-600 mb-2">
                        <a href="{{ route('docs.category', $doc->category->slug) }}" class="hover:underline">{{ $doc->category->name }}</a>
                    </div>
                    <a href="{{ route('docs.show', [$doc->category->slug, $doc->slug]) }}" class="block">
                        <h2 class="text-xl font-bold text-gray-900 hover:text-blue-600 transition-colors mb-2">{{ $doc->title }}</h2>
                    </a>
                    <p class="text-gray-600 text-sm line-clamp-3">
                        {{ Str::limit(strip_tags($doc->content), 200) }}
                    </p>
                    <div class="mt-4 text-xs text-gray-400 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Diperbarui {{ $doc->updated_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-xl font-bold text-gray-900 mb-1">Tidak ada hasil ditemukan</h3>
                <p class="text-gray-500">Kami tidak dapat menemukan dokumen yang cocok dengan kata kunci "{{ $query }}". Coba gunakan kata kunci lain.</p>
            </div>
        @endif
    </div>

</div>
@endsection
