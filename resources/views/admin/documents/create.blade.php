<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.documents.index') }}" class="text-slate-400 hover:text-alazhar transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-xl font-bold text-slate-900">Tulis Artikel Baru</h1>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-8">
                    <form action="{{ route('admin.documents.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <x-input-label for="title" :value="__('Judul Artikel')" class="text-slate-700 font-semibold mb-1" />
                                <x-text-input type="text" name="title" id="title" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:ring-alazhar focus:border-alazhar transition-colors" value="{{ old('title') }}" required autofocus placeholder="Masukkan judul yang menarik..." />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div class="md:col-span-1">
                                <x-input-label for="category_id" :value="__('Kategori')" class="text-slate-700 font-semibold mb-1" />
                                <select name="category_id" id="category_id" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-alazhar focus:ring-alazhar transition-colors sm:text-sm" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category_id') == $category->id || request('category_id') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="content-editor" :value="__('Isi Artikel')" class="text-slate-700 font-semibold mb-2" />
                            <div class="border border-slate-200 rounded-lg overflow-hidden shadow-sm">
                                <textarea name="content" id="content-editor" class="mt-1 block w-full border-0">{{ old('content') }}</textarea>
                            </div>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="mb-8 p-4 bg-slate-50 rounded-lg border border-slate-100 flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-alazhar shadow-sm focus:ring-alazhar focus:ring-offset-0 transition-colors">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_published" class="font-medium text-slate-700">Terbitkan Langsung</label>
                                <p class="text-slate-500">Jika tidak dicentang, artikel akan disimpan sebagai <em>Draft</em> dan tidak terlihat oleh pengunjung.</p>
                            </div>
                        </div>

                        <div class="flex justify-end items-center space-x-3 pt-4 border-t border-slate-100">
                            <a href="{{ route('admin.documents.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 disabled:opacity-25 transition-all duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-alazhar to-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-alazhar focus:ring-offset-2 transition-all duration-300">
                                Simpan Artikel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    @push('scripts')
    <!-- Integrasi TinyMCE tanpa API Key (Community Edition) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: '#content-editor',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            height: 600,
            content_style: 'body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; }',
            images_upload_handler: function (blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    const xhr = new XMLHttpRequest();
                    xhr.withCredentials = true;
                    xhr.open('POST', '/admin/upload-image');
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    xhr.upload.onprogress = (e) => {
                        progress(e.loaded / e.total * 100);
                    };
                    xhr.onload = () => {
                        if (xhr.status === 403) {
                            reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                            return;
                        }
                        if (xhr.status < 200 || xhr.status >= 300) {
                            reject('HTTP Error: ' + xhr.status);
                            return;
                        }
                        const json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location != 'string') {
                            reject('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        resolve(json.location);
                    };
                    xhr.onerror = () => {
                        reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                    };
                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                });
            },
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
