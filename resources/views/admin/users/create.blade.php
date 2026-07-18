<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.index') }}" class="text-slate-400 hover:text-alazhar transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-xl font-bold text-slate-900">Tambah Pengguna Baru</h1>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-8">
                    
                    <div class="mb-8 flex items-center space-x-4">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-alazhar">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Detail Akun</h3>
                            <p class="text-sm text-slate-500">Buat akun untuk pengelola dokumentasi baru.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-semibold mb-1" />
                            <x-text-input type="text" name="name" id="name" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:ring-alazhar focus:border-alazhar transition-colors" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Alamat Email')" class="text-slate-700 font-semibold mb-1" />
                            <x-text-input type="email" name="email" id="email" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:ring-alazhar focus:border-alazhar transition-colors" value="{{ old('email') }}" required placeholder="Contoh: budi@al-azhar.app" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>


                        <div class="mb-8 p-4 bg-slate-50 rounded-lg border border-slate-100 flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="is_superadmin" id="is_superadmin" value="1" {{ old('is_superadmin') ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-purple-600 shadow-sm focus:ring-purple-500 focus:ring-offset-0 transition-colors">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_superadmin" class="font-medium text-purple-700">Jadikan Superadmin</label>
                                <p class="text-slate-500">Superadmin memiliki akses penuh, termasuk mengelola akun pengguna lain.</p>
                            </div>
                        </div>

                        <div class="flex justify-end items-center space-x-3 pt-4 border-t border-slate-100">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 disabled:opacity-25 transition-all duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-alazhar to-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 transition-all duration-300">
                                Simpan Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</x-app-layout>
