@extends('layouts.blog')

@section('content')
<div class="max-w-[1100px] mx-auto px-4 pt-5">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- ============ MAIN COLUMN ============ -->
        <div class="lg:col-span-8">

            <!-- HERO SECTION -->
            @if($featuredPosts->count() > 0)
            <div class="mb-6">
                <!-- Big Hero -->
                <a href="{{ route('posts.show', $featuredPosts[0]->slug) }}" class="block relative rounded-xl overflow-hidden mb-3 group">
                    <div class="aspect-[16/9] bg-gray-200">
                        <img src="{{ $featuredPosts[0]->featured_image ? asset('storage/'.$featuredPosts[0]->featured_image) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=1200&auto=format&fit=crop' }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500" 
                            alt="{{ $featuredPosts[0]->title }}">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent flex flex-col justify-end p-5">
                        <h2 class="text-white text-xl font-black leading-tight mb-2 group-hover:text-red-300 transition">
                            {{ $featuredPosts[0]->title }}
                        </h2>
                        <div class="flex items-center gap-2 text-white/70 text-xs">
                            <span>{{ $featuredPosts[0]->published_at->format('d M Y, H:i') }} WIB</span>
                            <span>&bull;</span>
                            <span class="text-red-300 font-semibold">{{ $featuredPosts[0]->category->name ?? 'News' }}</span>
                        </div>
                    </div>
                </a>

                <!-- 3 Sub-Hero Cards -->
                <div class="grid grid-cols-3 gap-3">
                    @foreach($featuredPosts->skip(1)->take(3) as $fPost)
                    <a href="{{ route('posts.show', $fPost->slug) }}" class="group block">
                        <div class="aspect-[4/3] bg-gray-100 rounded-lg overflow-hidden mb-2">
                            <img src="{{ $fPost->featured_image ? asset('storage/'.$fPost->featured_image) : 'https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=600&auto=format&fit=crop' }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <h3 class="text-xs font-bold text-gray-900 group-hover:text-red-600 leading-snug line-clamp-3">{{ $fPost->title }}</h3>
                        <p class="text-gray-400 text-[10px] mt-1">{{ $fPost->published_at->format('d M Y, H:i') }} WIB</p>
                        <span class="category-red">{{ $fPost->category->name ?? 'News' }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- DIVIDER -->
            <div class="border-t border-gray-100 mb-6"></div>

            <!-- LATEST FEED - horizontal card list like IDNTimes -->
            <div class="mb-6">
                <h2 class="section-title mb-4">Berita Terbaru</h2>
                <div class="divide-y divide-gray-100">
                    @forelse($latestPosts as $post)
                    <a href="{{ route('posts.show', $post->slug) }}" class="flex gap-4 py-4 group">
                        <!-- Thumbnail -->
                        <div class="flex-shrink-0 w-28 h-20 sm:w-36 sm:h-24 bg-gray-100 rounded-lg overflow-hidden">
                            <img src="{{ $post->featured_image ? asset('storage/'.$post->featured_image) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=400&auto=format&fit=crop' }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <h3 class="article-title text-sm sm:text-base group-hover:text-red-600 transition line-clamp-3 mb-1">{{ $post->title }}</h3>
                            <p class="article-date">{{ $post->published_at->format('d M Y, H:i') }} WIB</p>
                            <span class="category-red">{{ $post->category->name ?? 'News' }}</span>
                        </div>
                    </a>
                    @empty
                    <div class="py-10 text-center text-gray-400 text-sm">Belum ada artikel.</div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $latestPosts->links() }}
                </div>
            </div>
        </div>

        <!-- ============ SIDEBAR ============ -->
        <div class="lg:col-span-4">
            <!-- Sticky sidebar -->
            <div class="sticky top-32 space-y-6">

                <!-- TRENDING -->
                <div>
                    <h3 class="section-title mb-4">Trending</h3>
                    <div class="divide-y divide-gray-100">
                        @foreach($popularPosts as $index => $popPost)
                        <a href="{{ route('posts.show', $popPost->slug) }}" class="flex gap-3 py-3 group">
                            <div class="flex-shrink-0 w-20 h-14 bg-gray-100 rounded-md overflow-hidden">
                                <img src="{{ $popPost->featured_image ? asset('storage/'.$popPost->featured_image) : 'https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=300&auto=format&fit=crop' }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-bold text-gray-900 group-hover:text-red-600 transition line-clamp-3 leading-snug">{{ $popPost->title }}</h4>
                                <p class="article-date mt-1">{{ $popPost->published_at->format('d M Y') }}</p>
                                <span class="category-red">{{ $popPost->category->name ?? 'News' }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- KATEGORI -->
                <div>
                    <h3 class="section-title mb-4">Kategori</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($categories as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" 
                            class="border border-gray-200 text-gray-600 hover:border-red-500 hover:text-red-600 text-xs font-semibold px-3 py-1.5 rounded-full transition">
                            {{ $cat->name }} <span class="text-gray-400">({{ $cat->posts_count }})</span>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
