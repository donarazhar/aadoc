<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Edit Dokumen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100">
                <div class="p-6 text-slate-900">
                    <form action="{{ route('admin.documents.update', $document->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Judul Dokumen')" />
                            <x-text-input type="text" name="title" id="title" class="mt-1 block w-full" value="{{ old('title', $document->title) }}" required autofocus />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-alazhar focus:ring-alazhar sm:text-sm" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $document->category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="content-editor" :value="__('Isi Dokumen (TinyMCE)')" />
                            <textarea name="content" id="content-editor" class="mt-1 block w-full">{{ old('content', $document->content) }}</textarea>
                        </div>

                        <div class="mb-6 flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $document->is_published) ? 'checked' : '' }} class="rounded border-slate-300 text-alazhar shadow-sm focus:ring-alazhar focus:ring-offset-0 focus:ring-2">
                            <label for="is_published" class="ml-2 block text-sm text-slate-700">Publikasikan Langsung</label>
                        </div>

                        <div class="flex justify-end mt-4">
                            <a href="{{ route('admin.documents.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-alazhar border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 transition ease-in-out duration-150 shadow-md shadow-blue-500/20">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Integrasi TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/ke2yr843uv7kjydevaiblj2mi0zm9uwvu9tikkn3sph5wdpc/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: '#content-editor',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            height: 500,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
