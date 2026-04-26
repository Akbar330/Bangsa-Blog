@extends('layouts.admin')

@section('page_title', 'Kelola Kategori')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Tambah -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-6 tracking-tight">Tambah Kategori</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Kategori</label>
                    <input type="text" name="name" class="w-full bg-gray-50 border-gray-200 border rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Teknologi" required>
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="3" class="w-full bg-gray-50 border-gray-200 border rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Penjelasan singkat kategori..."></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100">Simpan Kategori</button>
            </form>
        </div>
    </div>

    <!-- Daftar Tabel -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50/30 transition">
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-gray-800">{{ $category->name }}</p>
                            <p class="text-[10px] text-gray-400 font-medium">Slug: {{ $category->slug }}</p>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-gray-500">
                            {{ $category->posts_count }} Artikel
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">Belum ada kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
