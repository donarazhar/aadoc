<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-slate-900">Dashboard</h1>
    </x-slot>

    <div class="space-y-6">
        
        <!-- Premium Welcome Banner -->
        <div class="relative overflow-hidden bg-gradient-to-br from-alazhar via-blue-500 to-blue-700 rounded-2xl shadow-lg">
            <!-- Decorative blobs -->
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 right-24 w-32 h-32 bg-blue-300/20 rounded-full blur-xl"></div>
            <div class="absolute top-1/2 left-1/3 w-20 h-20 bg-white/5 rounded-full blur-lg"></div>

            <div class="relative z-10 p-8 md:p-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="text-white">
                    <span class="inline-block py-1 px-3 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-xs font-semibold tracking-wider uppercase mb-4">Admin Portal</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-2 drop-shadow-md">Selamat Datang, <br class="sm:hidden">{{ Auth::user()->name }}!</h2>
                    <p class="text-blue-100 text-sm md:text-base max-w-xl">Pusat kendali dokumentasi Al-Azhar Apps. Kelola kategori, perbarui panduan, dan pastikan orang tua murid mendapatkan informasi terbaik.</p>
                </div>
                <div class="text-white/80">
                    <svg class="w-24 h-24 md:w-32 md:h-32 drop-shadow-xl opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Quick Access Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <!-- Card: Kategori -->
            <a href="{{ route('admin.categories.index') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-start space-x-4 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-50 text-alazhar flex items-center justify-center group-hover:bg-alazhar group-hover:text-white transition-all duration-300 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-base font-bold text-slate-800 mb-1 group-hover:text-alazhar transition-colors duration-300">Kelola Kategori</h3>
                    <p class="text-sm text-slate-500">Atur pengelompokan dokumentasi fitur aplikasi.</p>
                </div>
            </a>

            <!-- Card: Artikel -->
            <a href="{{ route('admin.documents.index') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-start space-x-4 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-50 text-alazhar flex items-center justify-center group-hover:bg-alazhar group-hover:text-white transition-all duration-300 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-base font-bold text-slate-800 mb-1 group-hover:text-alazhar transition-colors duration-300">Kelola Artikel</h3>
                    <p class="text-sm text-slate-500">Tulis, perbarui, atau hapus panduan penggunaan.</p>
                </div>
            </a>

            <!-- Card: Pengguna -->
            <a href="{{ route('admin.users.index') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-start space-x-4 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-50 text-alazhar flex items-center justify-center group-hover:bg-alazhar group-hover:text-white transition-all duration-300 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-base font-bold text-slate-800 mb-1 group-hover:text-alazhar transition-colors duration-300">Akses Pengguna</h3>
                    <p class="text-sm text-slate-500">Atur otorisasi siapa saja yang bisa mengelola portal ini.</p>
                </div>
            </a>
        </div>

    </div>
</x-app-layout>
