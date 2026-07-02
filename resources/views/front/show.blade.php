@extends('layouts.front')

@section('title', ($document->title ?? $category->name) . ' - Al Azhar Apps')

@section('content')
<div class="hidden lg:block fixed z-20 inset-0 top-[3.8125rem] left-[max(0px,calc(50%-45rem))] right-auto w-[19.5rem] pb-10 px-8 overflow-y-auto">
    <nav id="nav" class="lg:text-sm lg:leading-6 relative pt-10 pb-8">
        @foreach($allCategories as $cat)
            @php
                $isActiveCat = isset($category) && $category->id === $cat->id;
            @endphp
            <div class="mb-8" x-data="{ open: {{ $isActiveCat ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between mb-3 group focus:outline-none text-left">
                    <h5 class="font-semibold text-slate-900 group-hover:text-laravel transition-colors pr-4">{{ $cat->name }}</h5>
                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0 transform transition-transform duration-200 group-hover:text-laravel" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <ul x-show="open" 
                    x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0 -translate-y-2" 
                    x-transition:enter-end="opacity-100 translate-y-0" 
                    class="space-y-3 border-l border-slate-100">
                    @foreach($cat->documents as $doc)
                        <li>
                            <a href="{{ route('docs.show', [$cat->slug, $doc->slug]) }}" 
                               class="block border-l -ml-px pl-4 
                               {{ isset($document) && $document->id === $doc->id ? 'border-laravel text-laravel font-semibold' : 'border-transparent hover:border-slate-400 text-slate-700 hover:text-slate-900' }}">
                                {{ $doc->title }}
                            </a>
                        </li>
                    @endforeach
                    @if($cat->documents->isEmpty())
                        <li><span class="block border-l -ml-px pl-4 border-transparent text-slate-400 italic">Belum ada dokumen</span></li>
                    @endif
                </ul>
            </div>
        @endforeach
    </nav>
</div>

<div class="lg:pl-[19.5rem]">
    <main class="max-w-3xl mx-auto pt-10 xl:max-w-none xl:ml-0 xl:mr-[15.5rem] xl:pr-16 pb-24">
        @if(isset($document))
            <!-- Document Header -->
            <header id="header" class="relative z-20">
                <div>
                    <p class="mb-2 text-sm leading-6 font-semibold text-laravel">{{ $category->name }}</p>
                    <div class="flex items-center">
                        <h1 class="inline-block text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">{{ $document->title }}</h1>
                    </div>
                </div>
            </header>

            <!-- Document Body -->
            <style>
                /* Menghilangkan bingkai, shadow, dan background dari kontainer hero, membiarkan gambar tampil utuh */
                .prose div[style*="max-width: 350px"],
                .prose div[style*="width: 120px"] {
                    border: none !important;
                    box-shadow: none !important;
                    background: transparent !important;
                }
                .prose div[style*="max-width: 350px"] p,
                .prose div[style*="width: 120px"] p {
                    margin: 0 !important;
                    width: 100%;
                }
                .prose div[style*="max-width: 350px"] img,
                .prose div[style*="width: 120px"] img {
                    margin: 0 !important;
                    width: 100% !important;
                    height: auto !important;
                    object-fit: contain !important;
                    border-radius: 1.5rem !important;
                }
            </style>
            <div class="mt-8 prose max-w-none">
                {!! $document->content !!}
            </div>
            
            <hr class="mt-12 mb-8 border-slate-200">
            <div class="flex items-center justify-between text-sm text-slate-600">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Terakhir diperbarui {{ $document->updated_at->diffForHumans() }}
                </div>
            </div>

        @else
            <!-- Category Fallback -->
            <header id="header" class="relative z-20">
                <div>
                    <h1 class="inline-block text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">{{ $category->name }}</h1>
                </div>
            </header>
            <div class="mt-8 prose">
                <p>Pilih dokumen dari menu di sebelah kiri untuk mulai membaca panduan mengenai modul ini.</p>
            </div>
        @endif
    </main>
</div>
@endsection
