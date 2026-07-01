<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-8 border border-slate-100">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Selamat Datang di Admin Portal!</h3>
                    <p class="text-slate-500">Anda berhasil masuk. Gunakan menu navigasi di atas untuk mengelola dokumentasi Al-Azhar Apps.</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Kategori Stat -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 flex items-center p-6">
                    <div class="p-4 bg-blue-50 text-alazhar rounded-lg mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500">Total Kategori</div>
                        <div class="text-3xl font-bold text-slate-800">{{ $totalCategories ?? 0 }}</div>
                    </div>
                </div>

                <!-- Dokumen Stat -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 flex items-center p-6">
                    <div class="p-4 bg-blue-50 text-alazhar rounded-lg mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500">Total Dokumen</div>
                        <div class="text-3xl font-bold text-slate-800">{{ $totalDocuments ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">Aksi Cepat</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('admin.documents.create') }}" class="inline-flex items-center justify-center px-4 py-3 bg-alazhar text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tulis Dokumen Baru
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center px-4 py-3 bg-white border border-slate-300 text-slate-700 rounded-lg font-medium hover:bg-slate-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Kategori
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-3 bg-white border border-slate-300 text-slate-700 rounded-lg font-medium hover:bg-slate-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Lihat Portal Publik
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
