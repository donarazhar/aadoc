<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.categories.index') }}" class="text-slate-400 hover:text-alazhar transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-xl font-bold text-slate-900">Detail Kategori</h1>
            </div>
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-semibold text-xs text-alazhar uppercase tracking-widest hover:bg-slate-50 hover:border-alazhar hover:text-blue-700 shadow-sm transition-all duration-200">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Kategori
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                
                <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between bg-slate-50/50">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <h3 class="text-2xl font-bold text-slate-900">{{ $category->name }}</h3>
                            @if($category->is_hidden)
                                <span class="inline-flex items-center rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700 border border-slate-300">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a10.05 10.05 0 015.188-1.563c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                    Tersembunyi
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 border border-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Publik
                                </span>
                            @endif
                        </div>
                        <p class="text-sm font-mono text-slate-500 bg-white inline-block px-2 py-1 border border-slate-200 rounded">URL Slug: /docs/{{ $category->slug }}</p>
                    </div>
                </div>
                
                <div class="p-8">
                    <div class="mb-8">
                        <h4 class="text-xs uppercase tracking-wider font-semibold text-slate-400 mb-2">Deskripsi Kategori</h4>
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 text-slate-700 leading-relaxed">
                            {{ $category->description ?: 'Tidak ada deskripsi.' }}
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-xs uppercase tracking-wider font-semibold text-slate-400">Dokumen di Kategori Ini</h4>
                            <span class="bg-blue-100 text-alazhar text-xs font-bold px-2 py-1 rounded-full">{{ $category->documents->count() }} Dokumen</span>
                        </div>
                        
                        @if($category->documents->count() > 0)
                            <div class="border border-slate-200 rounded-lg overflow-hidden">
                                <ul class="divide-y divide-slate-100">
                                    @foreach($category->documents as $doc)
                                        <li class="p-4 hover:bg-slate-50 transition-colors flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <a href="{{ route('admin.documents.show', $doc->id) }}" class="text-slate-700 font-medium hover:text-alazhar transition-colors">{{ $doc->title }}</a>
                                            </div>
                                            @if($doc->is_published)
                                                <span class="inline-block w-2.5 h-2.5 rounded-full bg-green-500" title="Diterbitkan"></span>
                                            @else
                                                <span class="inline-block w-2.5 h-2.5 rounded-full bg-slate-300" title="Draft"></span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-center py-8 border border-dashed border-slate-300 rounded-lg bg-slate-50">
                                <p class="text-slate-500 mb-2">Kategori ini belum memiliki dokumen.</p>
                                <a href="{{ route('admin.documents.create', ['category_id' => $category->id]) }}" class="text-alazhar hover:underline font-medium text-sm">Tambahkan Dokumen Pertama</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
    </div>
</x-app-layout>
