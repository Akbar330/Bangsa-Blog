@extends('layouts.admin')

@section('page_title', 'Edit Artikel')

@section('content')
<form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Kolom Utama -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-3 tracking-widest">Judul Artikel</label>
                    <input type="text" name="title" value="{{ $post->title }}" class="w-full text-2xl font-bold border-none bg-gray-50 focus:bg-white rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 transition-all outline-none" required>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-3 tracking-widest">Konten Berita</label>
                    <textarea name="content" id="editor" rows="15" class="w-full bg-gray-50 focus:bg-white border-none rounded-2xl p-6 text-gray-700 leading-relaxed focus:ring-2 focus:ring-blue-500 transition-all outline-none">{{ $post->content }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-3 tracking-widest">Ringkasan (Excerpt)</label>
                    <textarea name="excerpt" rows="3" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ $post->excerpt }}</textarea>
                </div>
            </div>
        </div>

        <!-- Kolom Sidebar Form -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Publish Card -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="mb-4">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Status</label>
                    <select name="status" class="w-full bg-gray-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="scheduled" {{ $post->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Tanggal Terbit</label>
                    <input type="datetime-local" name="published_at" class="w-full bg-gray-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500" value="{{ $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i') }}">
                </div>

                <div class="flex items-center gap-2 mb-6">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ $post->is_featured ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                    <label for="is_featured" class="text-sm font-semibold text-gray-700">Berita Utama</label>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 transition">
                    Perbarui Artikel
                </button>
            </div>

            <!-- Category & Tags -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="mb-6">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-3">Kategori</label>
                    <select name="category_id" class="w-full bg-gray-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $post->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-3">Tags</label>
                    <div class="max-h-40 overflow-y-auto space-y-2 pr-2 font-inter">
                        @foreach($tags as $tag)
                        <label class="flex items-center gap-3 bg-gray-50 p-2 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="text-xs font-semibold text-gray-600">#{{ $tag->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Image Upload Preview -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-4">Gambar Unggulan</label>
                @if($post->featured_image)
                    <div class="mb-4 rounded-xl overflow-hidden border border-gray-100">
                        <img src="{{ asset('storage/'.$post->featured_image) }}" class="w-full h-auto">
                    </div>
                @endif
                <div class="border-2 border-dashed border-gray-100 rounded-2xl p-6 text-center hover:border-blue-300 transition group">
                    <input type="file" name="featured_image" class="hidden" id="featured_image" accept="image/*">
                    <label for="featured_image" class="cursor-pointer">
                        <span class="text-xs font-bold text-gray-400 group-hover:text-blue-600 transition tracking-tighter uppercase underline decoration-blue-500 decoration-2">Ganti Foto Baru</span>
                    </label>
                </div>
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
</script>
@endsection
