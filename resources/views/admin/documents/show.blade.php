<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Preview Dokumen') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('docs.show', [$document->category->slug ?? 'uncategorized', $document->slug]) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-slate-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 focus:bg-slate-700 active:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    Lihat di Portal
                </a>
                <a href="{{ route('admin.documents.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 transition ease-in-out duration-150">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100">
                
                <!-- Document Header -->
                <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-200">
                            {{ $document->category->name ?? 'Tanpa Kategori' }}
                        </span>
                        @if($document->is_published)
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-green-200 flex items-center">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Published
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-yellow-200 flex items-center">
                                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span> Draft
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl font-extrabold text-slate-900 mb-2">{{ $document->title }}</h1>
                    <div class="flex items-center text-sm text-slate-500">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Diperbarui pada: {{ $document->updated_at->format('d M Y, H:i') }}
                    </div>
                </div>

                <!-- Document Content -->
                <div class="p-8">
                    <div class="prose prose-slate max-w-none prose-a:text-alazhar prose-headings:text-slate-800">
                        {!! $document->content !!}
                    </div>

                    <div class="mt-12 pt-6 border-t border-slate-100 flex justify-end">
                        <a href="{{ route('admin.documents.edit', $document->id) }}" class="inline-flex items-center px-6 py-2 bg-alazhar border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 transition ease-in-out duration-150 shadow-md shadow-blue-500/20">
                            Edit Dokumen
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
