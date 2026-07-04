<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.categories.index') }}" class="text-slate-400 hover:text-alazhar transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-xl font-bold text-slate-900">Tambah Kategori Baru</h1>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-8">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Nama Kategori')" class="text-slate-700 font-semibold mb-1" />
                            <x-text-input type="text" name="name" id="name" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:ring-alazhar focus:border-alazhar transition-colors" value="{{ old('name') }}" required autofocus placeholder="Contoh: Fitur Transaksi PMB" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Deskripsi Singkat')" class="text-slate-700 font-semibold mb-1" />
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:ring-alazhar focus:border-alazhar transition-colors" placeholder="Jelaskan secara singkat kegunaan kategori ini...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-8 p-4 bg-slate-50 rounded-lg border border-slate-100 flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="is_hidden" id="is_hidden" value="1" {{ old('is_hidden') ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-alazhar shadow-sm focus:ring-alazhar focus:ring-offset-0 transition-colors">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_hidden" class="font-medium text-slate-700">Sembunyikan dari Publik</label>
                                <p class="text-slate-500">Jika dicentang, kategori ini beserta seluruh isinya tidak akan muncul di halaman pengunjung.</p>
                            </div>
                        </div>

                        <div class="flex justify-end items-center space-x-3 pt-4 border-t border-slate-100">
                            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 disabled:opacity-25 transition-all duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-alazhar to-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 transition-all duration-300">
                                Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</x-app-layout>
