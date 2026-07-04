<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Manajemen Kategori') }}
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-alazhar to-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:shadow-lg hover:-translate-y-0.5 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 transition-all duration-300">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-sm flex items-center justify-between" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th scope="col" class="px-6 py-4 w-16 text-center text-slate-400">#</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Nama Kategori</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Slug</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-table-body">
                            @forelse ($categories as $category)
                                <tr class="bg-white border-b border-slate-100 hover:bg-blue-50/50 transition-colors duration-200" data-id="{{ $category->id }}">
                                    <td class="px-6 py-4 cursor-grab active:cursor-grabbing text-slate-400 hover:text-alazhar drag-handle flex justify-center items-center h-full">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-slate-900">
                                        {{ $category->name }}
                                        @if($category->is_hidden)
                                            <span class="ml-2 inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600 border border-slate-200">Tersembunyi</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $category->slug }}</td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="{{ route('admin.categories.show', $category->id) }}" class="inline-flex justify-center items-center w-8 h-8 rounded-md bg-white border border-slate-200 text-slate-500 hover:text-alazhar hover:border-alazhar hover:bg-blue-50 transition-all shadow-sm" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="inline-flex justify-center items-center w-8 h-8 rounded-md bg-white border border-slate-200 text-alazhar hover:text-white hover:bg-alazhar transition-all shadow-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hati-hati! Menghapus kategori ini juga akan menghapus semua dokumen di dalamnya. Yakin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex justify-center items-center w-8 h-8 rounded-md bg-white border border-slate-200 text-red-500 hover:text-white hover:bg-red-500 hover:border-red-500 transition-all shadow-sm" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <p class="text-base font-medium text-slate-500">Belum ada kategori yang dibuat.</p>
                                            <p class="text-sm">Silakan buat kategori pertama Anda untuk mengelompokkan dokumen.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('sortable-table-body');
            if(!el) return;
            var sortable = Sortable.create(el, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'bg-blue-50',
                onEnd: function (evt) {
                    var order = [];
                    el.querySelectorAll('tr[data-id]').forEach(function (row) {
                        order.push(row.getAttribute('data-id'));
                    });

                    fetch('/admin/categories/reorder', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            let toast = document.createElement('div');
                            toast.className = 'fixed bottom-4 right-4 bg-slate-800 text-white px-4 py-3 rounded-lg shadow-xl flex items-center space-x-3 transition-opacity duration-300 z-50';
                            toast.innerHTML = '<svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Urutan berhasil diperbarui</span>';
                            document.body.appendChild(toast);
                            setTimeout(() => {
                                toast.style.opacity = '0';
                                setTimeout(() => toast.remove(), 300);
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memperbarui urutan.');
                    });
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
