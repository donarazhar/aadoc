<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Tambah Pengguna') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100">
                <div class="p-6 sm:p-8 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-md border-slate-300 shadow-sm focus:border-alazhar focus:ring focus:ring-alazhar focus:ring-opacity-50" required autofocus>
                            @error('name')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-md border-slate-300 shadow-sm focus:border-alazhar focus:ring focus:ring-alazhar focus:ring-opacity-50" required>
                            @error('email')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Kata Sandi</label>
                            <input type="password" name="password" id="password" class="w-full rounded-md border-slate-300 shadow-sm focus:border-alazhar focus:ring focus:ring-alazhar focus:ring-opacity-50" required>
                            @error('password')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-md border-slate-300 shadow-sm focus:border-alazhar focus:ring focus:ring-alazhar focus:ring-opacity-50" required>
                        </div>

                        <!-- Role -->
                        <div class="mb-8">
                            <label for="role" class="block text-sm font-medium text-slate-700 mb-2">Tingkatan Akses (Role)</label>
                            <select name="role" id="role" class="w-full rounded-md border-slate-300 shadow-sm focus:border-alazhar focus:ring focus:ring-alazhar focus:ring-opacity-50" required>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (Hanya melihat publik)</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Mengelola kategori & dokumen)</option>
                                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin (Akses penuh & manajemen user)</option>
                            </select>
                            @error('role')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-slate-300 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-alazhar transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-alazhar border border-transparent rounded-md font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-alazhar transition-colors shadow-sm">
                                Simpan Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
