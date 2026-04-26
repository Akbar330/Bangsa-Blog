@extends('layouts.blog')

@section('title', $post->title . ' - BANGSA BLOG')
@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@section('content')
<div class="max-w-[1100px] mx-auto px-4 pt-5">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- ============ ARTICLE MAIN ============ -->
        <article class="lg:col-span-8">

            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-xs text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-red-600 transition">Home</a>
                <span>/</span>
                <a href="{{ route('category.show', $post->category->slug ?? '#') }}" class="hover:text-red-600 transition text-red-500 font-semibold">{{ $post->category->name ?? 'News' }}</a>
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight mb-4">{{ $post->title }}</h1>

            <!-- Meta -->
            <div class="flex items-center gap-3 text-xs text-gray-400 mb-5 pb-5 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-black text-xs uppercase">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                    <span class="font-semibold text-gray-600">{{ $post->user->name }}</span>
                </div>
                <span>&bull;</span>
                <span>{{ $post->published_at->format('d M Y, H:i') }} WIB</span>
                <span>&bull;</span>
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ number_format($post->views_count) }} views
                </span>
            </div>

            <!-- Featured Image -->
            <div class="mb-6 rounded-xl overflow-hidden bg-gray-100 aspect-video">
                <img src="{{ $post->featured_image ? asset('storage/'.$post->featured_image) : 'https://images.unsplash.com/photo-1542435503-956c469947f6?q=80&w=1200&auto=format&fit=crop' }}"
                    class="w-full h-full object-cover" alt="{{ $post->title }}">
            </div>

            <!-- Article Content -->
            <div class="prose prose-base max-w-none text-gray-800 leading-relaxed mb-8 prose-headings:font-black prose-a:text-red-600 prose-img:rounded-lg">
                {!! $post->content !!}
            </div>

            <!-- Tags -->
            @if($post->tags->count() > 0)
            <div class="flex flex-wrap gap-2 py-5 border-t border-b border-gray-100 mb-8">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider self-center mr-1">Tags:</span>
                @foreach($post->tags as $tag)
                    <a href="{{ route('tag.show', $tag->slug) }}" class="border border-gray-200 text-gray-600 hover:border-red-500 hover:text-red-600 text-xs font-semibold px-3 py-1 rounded-full transition">#{{ $tag->name }}</a>
                @endforeach
            </div>
            @endif

            <!-- Share -->
            <div class="flex items-center gap-3 mb-10">
                <span class="text-xs font-bold uppercase text-gray-400 tracking-wider">Bagikan:</span>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" class="bg-black text-white text-xs font-bold px-4 py-2 rounded-full hover:bg-gray-800 transition">Twitter/X</a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-full hover:bg-blue-700 transition">Facebook</a>
                <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}" target="_blank" class="bg-green-500 text-white text-xs font-bold px-4 py-2 rounded-full hover:bg-green-600 transition">WhatsApp</a>
            </div>

            <!-- Comments Section -->
            <section class="border-t border-gray-100 pt-8">
                <h3 class="section-title mb-6">
                    Komentar <span class="text-red-500 font-black ml-1">{{ $post->comments()->count() }}</span>
                </h3>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
                @endif

                @auth
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-red-100 flex-shrink-0 flex items-center justify-center text-red-600 font-black text-xs uppercase mt-1">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <textarea name="body" rows="3"
                                class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none resize-none @error('body') border-red-400 @enderror"
                                placeholder="Tulis komentar kamu...">{{ old('body') }}</textarea>
                            @error('body') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            <button type="submit" class="mt-2 bg-red-600 text-white text-xs font-bold px-5 py-2 rounded-full hover:bg-red-700 transition">Kirim Komentar</button>
                        </div>
                    </div>
                </form>
                @else
                <div class="bg-red-50 border border-red-100 rounded-lg p-5 mb-8 text-center">
                    <p class="text-gray-600 text-sm mb-3">Punya pendapat? <strong>Login</strong> dulu untuk komentar.</p>
                    <a href="{{ route('login') }}" class="bg-red-600 text-white text-xs font-bold px-5 py-2 rounded-full hover:bg-red-700 transition">Login Sekarang</a>
                </div>
                @endauth

                <!-- Comment List -->
                <div class="divide-y divide-gray-100">
                    @forelse($post->comments()->whereNull('parent_id')->with('user')->latest()->get() as $comment)
                    <div class="flex gap-3 py-4">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex-shrink-0 flex items-center justify-center text-gray-500 font-black text-xs uppercase">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-bold text-gray-900">{{ $comment->user->name }}</span>
                                <span class="text-[10px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->body }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-400 text-sm py-8 italic">Belum ada komentar. Jadilah yang pertama!</p>
                    @endforelse
                </div>
            </section>
        </article>

        <!-- ============ SIDEBAR ============ -->
        <aside class="lg:col-span-4">
            <div class="sticky top-32 space-y-6">
                <!-- Rekomendasi -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="section-title">Rekomendasi</h3>
                        <a href="{{ route('home') }}" class="text-xs text-red-600 font-semibold hover:underline">See More</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach(App\Models\Post::published()->where('id', '!=', $post->id)->inRandomOrder()->with('category')->take(6)->get() as $rec)
                        <a href="{{ route('posts.show', $rec->slug) }}" class="flex gap-3 py-3 group">
                            <div class="flex-shrink-0 w-20 h-14 bg-gray-100 rounded-md overflow-hidden">
                                <img src="{{ $rec->featured_image ? asset('storage/'.$rec->featured_image) : 'https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=300&auto=format&fit=crop' }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-bold text-gray-900 group-hover:text-red-600 transition line-clamp-3 leading-snug">{{ $rec->title }}</h4>
                                <p class="article-date mt-1">{{ $rec->published_at->format('d M Y') }}</p>
                                <span class="category-red">{{ $rec->category->name ?? 'News' }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>

    </div>
</div>
@endsection
