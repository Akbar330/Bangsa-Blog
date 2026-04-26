@extends('layouts.admin')

@section('page_title', 'Ringkasan Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Stat Card -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group">
        <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
            </svg>
        </div>
        <p class="text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">Total Artikel</p>
        <h3 class="text-3xl font-extrabold text-gray-900">{{ App\Models\Post::count() }}</h3>
    </div>
    
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group">
        <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <p class="text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">Total Views</p>
        <h3 class="text-3xl font-extrabold text-blue-600">{{ number_format(App\Models\Post::sum('views_count')) }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group">
        <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition text-orange-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
        </div>
        <p class="text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">Komentar</p>
        <h3 class="text-3xl font-extrabold text-orange-500">{{ App\Models\Comment::count() }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group">
        <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <p class="text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">Tim Redaksi</p>
        <h3 class="text-3xl font-extrabold text-gray-900">{{ App\Models\User::count() }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Posts -->
    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
        <h3 class="font-bold text-lg mb-6 flex items-center justify-between">
            Artikel Terbaru
            <a href="{{ route('admin.posts.index') }}" class="text-xs text-blue-600 hover:underline">Lihat Semua</a>
        </h3>
        <div class="space-y-5">
            @forelse(App\Models\Post::with('user')->latest()->take(5)->get() as $p)
            <div class="flex items-center justify-between py-1 border-b border-gray-50 last:border-0 pb-3">
                <div class="max-w-[70%]">
                    <p class="font-semibold text-sm text-gray-800 line-clamp-1">{{ $p->title }}</p>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight mt-1">{{ $p->user->name }} &bull; {{ $p->created_at->format('d M Y') }}</p>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[9px] font-bold px-2 py-0.5 rounded {{ $p->status == 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} uppercase mb-1">
                        {{ $p->status }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-4">Belum ada artikel.</p>
            @endforelse
        </div>
    </div>

    <!-- Popular Posts -->
    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
        <h3 class="font-bold text-lg mb-6">Penforma Terbaik</h3>
        <div class="space-y-6">
            @forelse(App\Models\Post::trending()->take(5)->get() as $p)
            <div>
                <div class="flex justify-between items-center mb-2">
                    <p class="text-sm font-semibold text-gray-800 line-clamp-1">{{ $p->title }}</p>
                    <span class="text-xs font-bold text-gray-500">{{ number_format($p->views_count) }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    @php 
                        $max = App\Models\Post::max('views_count') ?: 1;
                        $percent = ($p->views_count / $max) * 100;
                    @endphp
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-4">Belum ada data traffic.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
