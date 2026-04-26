@extends('layouts.blog')

@section('title', 'Hasil Pencarian: ' . $query . ' - BANGSA BLOG')

@section('content')
<div class="max-w-[1100px] mx-auto px-4 pt-5">

    <!-- Search Box (repeat) -->
    <div class="mb-8">
        <form action="{{ route('search') }}" method="GET" class="flex gap-2 max-w-xl">
            <input type="text" name="q" value="{{ $query }}"
                class="flex-1 border border-gray-300 rounded-full px-5 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none"
                placeholder="Cari berita...">
            <button type="submit" class="bg-red-600 text-white text-sm font-bold px-6 py-2.5 rounded-full hover:bg-red-700 transition">
                Cari
            </button>
        </form>
    </div>

    <!-- Result Meta -->
    <div class="border-b border-gray-200 pb-4 mb-6">
        <h1 class="text-lg font-black text-gray-900">
            @if($query)
                Menampilkan <span class="text-red-600">{{ $posts->total() }}</span> hasil untuk "<span class="italic">{{ $query }}</span>"
            @else
                Semua Artikel
            @endif
        </h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8">
            <div class="divide-y divide-gray-100">
                @forelse($posts as $post)
                <a href="{{ route('posts.show', $post->slug) }}" class="flex gap-4 py-4 group">
                    <div class="flex-shrink-0 w-32 h-22 sm:w-40 sm:h-28 bg-gray-100 rounded-lg overflow-hidden">
                        <img src="{{ $post->featured_image ? asset('storage/'.$post->featured_image) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=400&auto=format&fit=crop' }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="article-title text-sm sm:text-base group-hover:text-red-600 transition line-clamp-3 mb-1">{{ $post->title }}</h3>
                        <p class="text-gray-500 text-xs line-clamp-2 mb-2 hidden sm:block">
                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                        </p>
                        <p class="article-date">{{ $post->published_at->format('d M Y, H:i') }} WIB</p>
                        <span class="category-red">{{ $post->category->name ?? 'News' }}</span>
                    </div>
                </a>
                @empty
                <div class="py-20 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <p class="text-gray-400 italic text-sm mb-4">Tidak ada artikel yang cocok dengan pencarian kamu.</p>
                    <a href="{{ route('home') }}" class="text-red-600 text-sm font-semibold hover:underline">Kembali ke Beranda</a>
                </div>
                @endforelse
            </div>
            <div class="mt-8">{{ $posts->links() }}</div>
        </div>

        <aside class="lg:col-span-4">
            <div class="sticky top-32">
                <h3 class="section-title mb-4">Kategori</h3>
                <div class="divide-y divide-gray-100">
                    @foreach(App\Models\Category::withCount('posts')->get() as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="flex items-center justify-between py-3 group">
                        <span class="text-sm font-semibold text-gray-700 group-hover:text-red-600 transition">{{ $cat->name }}</span>
                        <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $cat->posts_count }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
