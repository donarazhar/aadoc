<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.documents.index') }}" class="text-slate-400 hover:text-alazhar transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-xl font-bold text-slate-900">Pratinjau Artikel</h1>
            </div>
            <a href="{{ route('admin.documents.edit', $document->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-semibold text-xs text-alazhar uppercase tracking-widest hover:bg-slate-50 hover:border-alazhar hover:text-blue-700 shadow-sm transition-all duration-200">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Artikel
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-2xl border border-slate-200">
                
                <!-- Article Header -->
                <div class="p-8 md:p-10 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="px-2.5 py-1 bg-blue-100 text-alazhar text-xs font-bold uppercase tracking-wider rounded-md">{{ $document->category->name ?? 'Tanpa Kategori' }}</span>
                        @if($document->is_published)
                            <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wider rounded-md flex items-center">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Publik
                            </span>
                        @else
                            <span class="px-2.5 py-1 bg-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider rounded-md flex items-center">
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-1.5"></span> Draft
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-4">
                        {{ $document->title }}
                    </h1>
                    
                    <div class="flex items-center text-sm text-slate-500 space-x-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $document->author->name ?? 'Anonim' }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Dibuat: {{ $document->created_at->format('d M Y, H:i') }}
                        </div>
                        @if($document->updated_at->gt($document->created_at))
                            <div class="flex items-center text-slate-400">
                                (Diperbarui: {{ $document->updated_at->format('d M Y') }})
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Article Content -->
                <div class="p-8 md:p-10 prose prose-slate max-w-none prose-headings:text-slate-800 prose-a:text-alazhar hover:prose-a:text-blue-700 prose-img:rounded-xl prose-img:shadow-md">
                    {!! $document->content !!}
                </div>

                @if(trim(strip_tags($document->content)) == '')
                    <div class="p-8 text-center text-slate-400 italic bg-slate-50 border-t border-slate-100">
                        Konten artikel ini masih kosong.
                    </div>
                @endif
            </div>

            <!-- Preview Link -->
            @if($document->is_published && $document->category)
            <div class="mt-6 text-center">
                <a href="{{ route('docs.show', ['categorySlug' => $document->category->slug, 'documentSlug' => $document->slug]) }}" target="_blank" class="inline-flex items-center text-sm font-medium text-alazhar hover:text-blue-700 transition-colors">
                    Lihat artikel ini di portal publik
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
            @endif
    </div>
</x-app-layout>
