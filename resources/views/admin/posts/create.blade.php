@extends('layouts.admin')

@section('page_title', 'Tulis Artikel Baru')

@section('content')
<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Kolom Utama -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-3 tracking-widest">Judul Artikel</label>
                    <input type="text" name="title" class="w-full text-2xl font-bold border-none bg-gray-50 focus:bg-white rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="Masukkan judul yang menarik..." required>
                </div>

                <div class="mb-6 ck-editor-container">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-3 tracking-widest">Konten Berita</label>
                    <textarea name="content" id="editor" rows="15" class="w-full bg-gray-50 focus:bg-white border-none rounded-2xl p-6 text-gray-700 leading-relaxed focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="Mulaiah menulis isi berita di sini..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-3 tracking-widest">Ringkasan (Excerpt)</label>
                    <textarea name="excerpt" rows="3" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Ringkasan singkat untuk SEO dan media sosial..."></textarea>
                </div>
            </div>
        </div>

        <!-- Kolom Sidebar Form -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Publish Card -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h4 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Pengaturan Publikasi
                </h4>
                
                <div class="mb-4">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Status</label>
                    <select name="status" class="w-full bg-gray-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="draft">Draft (Simpan Saja)</option>
                        <option value="published">Published (Terbit Langsung)</option>
                        <option value="scheduled">Scheduled (Dijadwalkan)</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Tanggal Terbit</label>
                    <input type="datetime-local" name="published_at" class="w-full bg-gray-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500" value="{{ now()->format('Y-m-d\TH:i') }}">
                </div>

                <div class="flex items-center gap-2 mb-6">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" class="rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                    <label for="is_featured" class="text-sm font-semibold text-gray-700">Jadikan Berita Utama</label>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center justify-center gap-2">
                    Simpan & Terbitkan
                </button>
            </div>

            <!-- Category & Tags -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="mb-6">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-3">Kategori</label>
                    <select name="category_id" class="w-full bg-gray-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-3">Tags</label>
                    <div class="max-h-40 overflow-y-auto space-y-2 pr-2">
                        @foreach($tags as $tag)
                        <label class="flex items-center gap-3 bg-gray-50 p-2 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="text-xs font-semibold text-gray-600">#{{ $tag->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-4">Gambar Unggulan</label>
                <div class="border-2 border-dashed border-gray-100 rounded-2xl p-6 text-center hover:border-blue-300 transition group">
                    <input type="file" name="featured_image" class="hidden" id="featured_image" accept="image/*" onchange="previewImage(event)">
                    <label for="featured_image" class="cursor-pointer">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-200 group-hover:text-blue-500 mb-3 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs font-bold text-gray-400 group-hover:text-blue-600 transition">Klik untuk upload foto</span>
                        </div>
                    </label>
                </div>
                <p class="text-[10px] text-gray-400 mt-3 italic text-center">Format: JPG, PNG, WEBP (Maks 2MB)</p>
            </div>

        </div>
    </div>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
        })
        .catch(error => {
            console.error(error);
        });

    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            console.log("File selected: " + input.files[0].name);
        }
    }
</script>
@endsection
