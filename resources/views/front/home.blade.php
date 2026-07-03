@extends('layouts.front')

@section('title', 'Pusat Bantuan & Dokumentasi - Al Azhar Apps')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-primary text-white py-20 px-4 sm:px-6 lg:px-8 overflow-hidden relative">
    <!-- Decorative blobs -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-300 opacity-20 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>

    <div class="max-w-3xl mx-auto text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6 animate-fade-in-up">
            Pusat Bantuan Al Azhar Apps
        </h1>
        <p class="text-lg md:text-xl text-blue-100 mb-10">
            Temukan panduan lengkap, tutorial, dan dokumentasi teknis untuk mengelola sistem informasi sekolah dengan mudah.
        </p>

        <!-- Large Search Bar -->
        <form action="{{ route('docs.search') }}" method="GET" class="relative max-w-2xl mx-auto">
            <input type="text" name="q" placeholder="Ketik kata kunci pencarian (contoh: cara input pmb...)" class="w-full pl-12 pr-6 py-4 rounded-2xl border-0 shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-300/50 text-gray-800 text-lg transition-all" required>
            <svg class="w-6 h-6 text-gray-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <button type="submit" class="absolute right-2 top-2 bottom-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl px-6 transition-colors">
                Cari
            </button>
        </form>
    </div>
</div>

<!-- Categories Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900">Jelajahi Berdasarkan Kategori</h2>
        <p class="mt-4 text-gray-600">Pilih modul aplikasi yang ingin Anda pelajari lebih lanjut.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($categories as $category)
            <a href="{{ route('docs.category', $category->slug) }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <!-- Icon placeholder -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">{{ $category->name }}</h3>
                <p class="text-gray-600 mb-4 line-clamp-2">
                    {{ $category->description ?? 'Dokumentasi dan panduan seputar modul ' . $category->name . '.' }}
                </p>
                <div class="flex items-center text-sm font-medium text-blue-600">
                    {{ $category->documents_count }} Artikel
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
