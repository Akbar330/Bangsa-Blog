@extends('layouts.blog')

@section('title', 'Tag: #' . $tag->name . ' - BANGSA BLOG')

@section('content')
<div class="max-w-[1100px] mx-auto px-4 pt-5">

    <div class="border-b border-gray-200 pb-4 mb-6">
        <div class="flex items-center gap-2 text-xs text-gray-400 mb-2">
            <a href="{{ route('home') }}" class="hover:text-red-600">Home</a>
            <span>/</span>
            <span class="text-red-600 font-semibold">#{{ $tag->name }}</span>
        </div>
        <h1 class="text-2xl font-black text-gray-900">
            Artikel dengan tag: <span class="text-red-600">#{{ $tag->name }}</span>
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
                        <p class="article-date">{{ $post->published_at->format('d M Y, H:i') }} WIB</p>
                        <span class="category-red">{{ $post->category->name ?? 'News' }}</span>
                    </div>
                </a>
                @empty
                <div class="py-16 text-center">
                    <p class="text-gray-400 italic text-sm">Belum ada artikel dengan tag ini.</p>
                    <a href="{{ route('home') }}" class="mt-3 inline-block text-red-600 text-sm font-semibold hover:underline">Kembali ke Beranda</a>
                </div>
                @endforelse
            </div>
            <div class="mt-8">{{ $posts->links() }}</div>
        </div>

        <aside class="lg:col-span-4">
            <div class="sticky top-32">
                <h3 class="section-title mb-4">Kategori Populer</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(App\Models\Category::withCount('posts')->orderByDesc('posts_count')->get() as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}"
                        class="border border-gray-200 text-gray-600 hover:border-red-500 hover:text-red-600 text-xs font-semibold px-3 py-1.5 rounded-full transition">
                        {{ $cat->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
