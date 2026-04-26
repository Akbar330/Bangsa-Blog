@extends('layouts.blog')

@section('title', 'Kategori: ' . $category->name . ' - BANGSA BLOG')

@section('content')
<div class="max-w-[1100px] mx-auto px-4 pt-5">

    <!-- Page Header -->
    <div class="border-b border-gray-200 pb-4 mb-6">
        <div class="flex items-center gap-2 text-xs text-gray-400 mb-2">
            <a href="{{ route('home') }}" class="hover:text-red-600">Home</a>
            <span>/</span>
            <span class="text-red-600 font-semibold">{{ $category->name }}</span>
        </div>
        <h1 class="text-2xl font-black text-gray-900">{{ $category->name }}</h1>
        @if($category->description)
        <p class="text-sm text-gray-500 mt-1">{{ $category->description }}</p>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Main Feed -->
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
                        <span class="category-red">{{ $category->name }}</span>
                    </div>
                </a>
                @empty
                <div class="py-16 text-center">
                    <p class="text-gray-400 text-sm italic">Belum ada artikel di kategori ini.</p>
                    <a href="{{ route('home') }}" class="mt-4 inline-block text-red-600 text-sm font-semibold hover:underline">Kembali ke Beranda</a>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">{{ $posts->links() }}</div>
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-4">
            <div class="sticky top-32">
                <h3 class="section-title mb-4">Kategori Lainnya</h3>
                <div class="divide-y divide-gray-100">
                    @foreach(App\Models\Category::withCount('posts')->where('id', '!=', $category->id)->get() as $cat)
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
