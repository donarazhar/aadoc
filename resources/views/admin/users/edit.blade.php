<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.index') }}" class="text-slate-400 hover:text-alazhar transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-xl font-bold text-slate-900">Edit Pengguna: <span class="text-alazhar">{{ $user->name }}</span></h1>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-8">
                    
                    <div class="mb-8 flex items-center space-x-4">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-alazhar text-2xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Perbarui Profil</h3>
                            <p class="text-sm text-slate-500">Ubah informasi dasar atau hak akses pengguna.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-semibold mb-1" />
                            <x-text-input type="text" name="name" id="name" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:ring-alazhar focus:border-alazhar transition-colors" value="{{ old('name', $user->name) }}" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Alamat Email')" class="text-slate-700 font-semibold mb-1" />
                            <x-text-input type="email" name="email" id="email" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:ring-alazhar focus:border-alazhar transition-colors" value="{{ old('email', $user->email) }}" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mb-8">
                            <x-input-label for="password" :value="__('Kata Sandi Baru (Opsional)')" class="text-slate-700 font-semibold mb-1" />
                            <x-text-input type="password" name="password" id="password" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:ring-alazhar focus:border-alazhar transition-colors" placeholder="Biarkan kosong jika tidak ingin mengubah sandi" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Jangan izinkan superadmin menghapus role-nya sendiri -->
                        @if(auth()->id() !== $user->id)
                            <div class="mb-8 p-4 bg-slate-50 rounded-lg border border-slate-100 flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="is_superadmin" id="is_superadmin" value="1" {{ old('is_superadmin', $user->isSuperadmin()) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-purple-600 shadow-sm focus:ring-purple-500 focus:ring-offset-0 transition-colors">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_superadmin" class="font-medium text-purple-700">Jadikan Superadmin</label>
                                    <p class="text-slate-500">Superadmin memiliki akses penuh, termasuk mengelola akun pengguna lain.</p>
                                </div>
                            </div>
                        @else
                            <div class="mb-8 p-4 bg-purple-50 rounded-lg border border-purple-100 flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" checked disabled class="w-4 h-4 rounded border-slate-300 text-purple-600 opacity-50 cursor-not-allowed">
                                    <input type="hidden" name="is_superadmin" value="1">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label class="font-medium text-purple-700">Akun Anda adalah Superadmin</label>
                                    <p class="text-purple-500/70">Anda tidak dapat mencabut akses superadmin dari akun Anda sendiri.</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-end items-center space-x-3 pt-4 border-t border-slate-100">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 disabled:opacity-25 transition-all duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-alazhar to-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 transition-all duration-300">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</x-app-layout>
