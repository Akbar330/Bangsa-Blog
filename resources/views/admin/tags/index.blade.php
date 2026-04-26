@extends('layouts.admin')

@section('page_title', 'Kelola Tags')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-6 tracking-tight">Tambah Tag Baru</h3>
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2 text-slate-400">Nama Tag</label>
                    <input type="text" name="name" class="w-full bg-slate-50 border-slate-100 border rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="#trending" required>
                </div>
                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3 rounded-xl hover:bg-slate-800 transition">Tambah Tag</button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 overflow-hidden">
            <div class="flex flex-wrap gap-3">
                @forelse($tags as $tag)
                <div class="flex items-center gap-2 bg-slate-100 px-4 py-2 rounded-xl group transition hover:bg-red-50">
                    <span class="text-sm font-semibold text-slate-700">#{{ $tag->name }}</span>
                    <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-slate-300 hover:text-red-500 transition opacity-0 group-hover:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
                @empty
                <p class="text-slate-400 italic text-sm">Belum ada tag.</p>
                @endforelse
            </div>
            
            <div class="mt-8">
                {{ $tags->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
