<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Manajemen Dokumen') }}
            </h2>
            <a href="{{ route('admin.documents.create') }}" class="inline-flex items-center px-4 py-2 bg-alazhar border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 transition ease-in-out duration-150">
                + Tulis Dokumen Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100">
                <style>
                    #sortable-table-body {
                        counter-reset: rowNumber;
                    }
                    #sortable-table-body tr.document-row {
                        counter-increment: rowNumber;
                    }
                    #sortable-table-body tr.document-row .row-num::before {
                        content: counter(rowNumber);
                    }
                </style>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 w-12 text-center">No</th>
                                <th scope="col" class="px-6 py-4">Judul Dokumen</th>
                                <th scope="col" class="px-6 py-4">Kategori</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                                <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-table-body">
                            @forelse ($documents as $document)
                                <tr class="document-row bg-white border-b border-slate-50 hover:bg-slate-50" data-id="{{ $document->id }}">
                                    <td class="px-6 py-4 text-center text-slate-500 whitespace-nowrap">
                                        <span class="drag-handle cursor-grab active:cursor-grabbing mr-2 text-slate-400 hover:text-slate-600 inline-block align-middle" title="Geser untuk mengubah urutan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                                        </span>
                                        <span class="row-num inline-block align-middle font-medium"></span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-slate-900">{{ $document->title }}</td>
                                    <td class="px-6 py-4">
                                        <span class="bg-slate-100 text-slate-800 text-xs font-medium px-2.5 py-0.5 rounded border border-slate-200">
                                            {{ $document->category->name ?? 'Tanpa Kategori' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($document->is_published)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-200">Published</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-200">Draft</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-3">
                                        <a href="{{ route('admin.documents.show', $document->id) }}" class="text-slate-500 hover:text-slate-900 transition-colors inline-block" title="Lihat">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('admin.documents.edit', $document->id) }}" class="text-alazhar hover:text-blue-700 transition-colors inline-block" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.documents.destroy', $document->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada dokumen yang ditulis.</td>
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
            var sortable = Sortable.create(el, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'bg-slate-100',
                onEnd: function (evt) {
                    var order = [];
                    el.querySelectorAll('tr[data-id]').forEach(function (row) {
                        order.push(row.getAttribute('data-id'));
                    });

                    fetch('/admin/documents/reorder', {
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
                            console.log('Urutan berhasil diperbarui.');
                            let toast = document.createElement('div');
                            toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg transition-opacity duration-300 z-50';
                            toast.innerText = 'Urutan dokumen berhasil diperbarui';
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
