@extends('layouts.admin')

@section('page_title', 'Kelola Artikel')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-center bg-gray-50/30 gap-4">
        <div>
            <h3 class="font-bold text-gray-800">Daftar Semua Artikel</h3>
            <p class="text-xs text-gray-500 mt-1">Total {{ $posts->total() }} artikel ditemukan dalam sistem.</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="bg-blue-600 text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-blue-700 transition flex items-center gap-2 shadow-lg shadow-blue-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tulis Artikel Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-[10px] font-bold uppercase tracking-widest text-gray-400 bg-gray-50/20 border-b border-gray-50">
                    <th class="px-6 py-5">Info Artikel</th>
                    <th class="px-6 py-5">Kategori</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5">Traffic</th>
                    <th class="px-6 py-5 text-right uppercase">Kontrol</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($posts as $post)
                <tr class="hover:bg-gray-50/30 transition group">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-11 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100 border border-gray-100 shadow-sm">
                                <img src="{{ $post->featured_image ? asset('storage/'.$post->featured_image) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=2070&auto=format&fit=crop' }}" 
                                    class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 leading-snug line-clamp-1 mb-1">{{ $post->title }}</p>
                                <div class="flex items-center gap-2 text-[10px] text-gray-400 font-bold uppercase tracking-tighter">
                                    <span class="text-blue-500">{{ $post->user->name }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $post->created_at->format('d M, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wide">
                            {{ $post->category->name ?? 'Update' }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-2">
                             <span class="w-2 h-2 rounded-full {{ $post->status == 'published' ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500' }}"></span>
                             <span class="text-[10px] font-extrabold {{ $post->status == 'published' ? 'text-emerald-700' : 'text-amber-700' }} uppercase tracking-wide">
                                {{ $post->status }}
                             </span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex flex-col">
                            <span class="text-sm font-extrabold text-slate-700 tracking-tight">{{ number_format($post->views_count) }}</span>
                            <span class="text-[9px] text-slate-400 font-bold uppercase">views</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition duration-300">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit Artikel">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini permanen?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
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
                    <td colspan="5" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <p class="text-gray-400 italic text-sm">Belum ada artikel yang ditulis.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($posts->hasPages())
    <div class="px-6 py-5 bg-gray-50/20 border-t border-gray-50">
        {{ $posts->links() }}
    </div>
    @endif
</div>
@endsection
