<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Detail Kategori') }}
            </h2>
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 transition ease-in-out duration-150">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100">
                <div class="p-8">
                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Kategori</h3>
                        <p class="text-lg text-slate-900 font-medium">{{ $category->name }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Slug</h3>
                        <p class="text-slate-700 bg-slate-50 p-2 rounded border border-slate-100 inline-block">{{ $category->slug }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Deskripsi</h3>
                        <p class="text-slate-700">{{ $category->description ?: 'Tidak ada deskripsi.' }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Urutan (Order)</h3>
                        <p class="text-slate-700">{{ $category->order }}</p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex space-x-3">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="inline-flex items-center px-4 py-2 bg-alazhar border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            Edit Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
