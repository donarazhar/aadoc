<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Premium Welcome Banner -->
            <div class="relative overflow-hidden bg-gradient-to-r from-alazhar to-blue-600 rounded-2xl shadow-lg border border-blue-400/30">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 right-24 w-24 h-24 bg-blue-300 opacity-20 rounded-full blur-xl"></div>
                
                <div class="relative p-8 md:p-12 z-10 flex flex-col md:flex-row items-center justify-between">
                    <div class="text-white w-full">
                        <span class="inline-block py-1 px-3 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-xs font-semibold tracking-wider uppercase mb-4 shadow-sm">Admin Portal</span>
                        <h3 class="text-3xl md:text-4xl font-extrabold mb-3 drop-shadow-md">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="text-blue-100 text-base md:text-lg max-w-2xl font-medium">Ini adalah pusat kendali dokumentasi Al-Azhar Apps. Kelola kategori, perbarui panduan, dan pastikan orang tua murid mendapatkan informasi terbaik.</p>
                    </div>
                    <div class="hidden md:block w-48 opacity-90 drop-shadow-2xl">
                        <!-- Simple abstract graphic or icon -->
                        <svg class="w-full h-full text-white/80" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Quick Access / Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: Kategori -->
                <a href="{{ route('admin.categories.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 p-6 flex items-start space-x-4 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-blue-50 rounded-bl-full -z-10 group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                    <div class="flex-shrink-0 bg-blue-100/50 p-3 rounded-lg text-alazhar group-hover:bg-alazhar group-hover:text-white transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-800 mb-1 group-hover:text-alazhar transition-colors duration-300">Kelola Kategori</h4>
                        <p class="text-sm text-slate-500">Atur pengelompokan dokumentasi fitur aplikasi.</p>
                    </div>
                </a>

                <!-- Card 2: Dokumen -->
                <a href="{{ route('admin.documents.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 p-6 flex items-start space-x-4 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-blue-50 rounded-bl-full -z-10 group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                    <div class="flex-shrink-0 bg-blue-100/50 p-3 rounded-lg text-alazhar group-hover:bg-alazhar group-hover:text-white transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-800 mb-1 group-hover:text-alazhar transition-colors duration-300">Kelola Artikel</h4>
                        <p class="text-sm text-slate-500">Tulis, perbarui, atau hapus panduan penggunaan.</p>
                    </div>
                </a>

                <!-- Card 3: Pengguna -->
                <a href="{{ route('admin.users.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 p-6 flex items-start space-x-4 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-blue-50 rounded-bl-full -z-10 group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                    <div class="flex-shrink-0 bg-blue-100/50 p-3 rounded-lg text-alazhar group-hover:bg-alazhar group-hover:text-white transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-800 mb-1 group-hover:text-alazhar transition-colors duration-300">Akses Pengguna</h4>
                        <p class="text-sm text-slate-500">Atur otorisasi siapa saja yang bisa mengelola portal ini.</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
