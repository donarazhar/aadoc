<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Selamat Datang di Admin Portal!</h3>
                    <p class="text-slate-500">Anda berhasil masuk. Gunakan menu navigasi di atas untuk mengelola dokumentasi Al-Azhar Apps.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
