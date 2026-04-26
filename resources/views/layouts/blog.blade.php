<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'BANGSA Blog'))</title>
    <meta name="description" content="@yield('meta_description', 'Portal berita dan blog profesional terlengkap.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800;0,14..32,900;1,14..32,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        .nav-link { font-size: 13px; font-weight: 500; color: #333; white-space: nowrap; }
        .nav-link:hover, .nav-link.active { color: #e53e3e; }
        .category-red { color: #e53e3e; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .article-title { font-weight: 700; color: #1a1a1a; line-height: 1.4; }
        .article-date { font-size: 11px; color: #999; margin: 2px 0; }
        .section-title { font-size: 15px; font-weight: 800; color: #1a1a1a; text-transform: uppercase; border-left: 3px solid #e53e3e; padding-left: 10px; }
    </style>
</head>
<body class="bg-white text-gray-900">

    <!-- Top Navbar -->
    <header class="border-b border-gray-200 bg-white sticky top-0 z-50">
        <div class="max-w-[1100px] mx-auto px-4">
            <!-- Row 1: Logo + Search + Login -->
            <div class="flex items-center justify-between h-14">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-baseline gap-0 flex-shrink-0">
                    <span style="font-size:26px; font-weight:900; color:#e53e3e; font-family:'Inter',sans-serif; letter-spacing:-1px;">BANGSA</span>
                    <span style="font-size:26px; font-weight:900; color:#1a1a1a; font-family:'Inter',sans-serif; letter-spacing:-1px;">BLOG</span>
                </a>

                <!-- Category Nav (hidden mobile) -->
                <nav class="hidden lg:flex items-center gap-5 mx-6 flex-1 overflow-hidden">
                    <a href="{{ route('home') }}" class="nav-link active">Home</a>
                    @foreach(App\Models\Category::take(8)->get() as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" class="nav-link">{{ $cat->name }}</a>
                    @endforeach
                </nav>

                <!-- Right: Search + Login -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    <form action="{{ route('search') }}" method="GET">
                        <button type="submit" class="text-gray-500 hover:text-red-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        <input type="text" name="q" class="hidden">
                    </form>

                    @auth
                        @if(auth()->user()->hasAnyRole(['admin', 'editor', 'writer']))
                            <a href="{{ route('admin.dashboard') }}" class="bg-red-600 text-white text-xs font-bold px-4 py-2 rounded-full hover:bg-red-700 transition whitespace-nowrap">Dashboard</a>
                        @else
                            <a href="{{ route('profile.edit') }}" class="bg-red-600 text-white text-xs font-bold px-4 py-2 rounded-full hover:bg-red-700 transition whitespace-nowrap">Profil Saya</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-red-600 text-white text-xs font-bold px-4 py-2 rounded-full hover:bg-red-700 transition whitespace-nowrap flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                            </svg>
                            Masuk/Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- "For You" Bar -->
        <div class="bg-red-600 py-2">
            <div class="max-w-[1100px] mx-auto px-4 flex items-center gap-3 overflow-x-auto">
                <span class="text-white text-xs font-black whitespace-nowrap uppercase flex-shrink-0">For<br>You</span>
                <div class="flex gap-2 overflow-x-auto pb-0.5">
                    @foreach(App\Models\Category::all() as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="bg-white/15 hover:bg-white/25 text-white text-xs font-semibold px-3 py-1 rounded-full whitespace-nowrap transition border border-white/20">
                        #{{ $cat->name }}
                    </a>
                    @endforeach
                    <a href="{{ route('search') }}" class="bg-white/15 hover:bg-white/25 text-white text-xs font-semibold px-3 py-1 rounded-full whitespace-nowrap transition border border-white/20">Trending</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pb-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10 mt-10 border-t-4 border-red-600">
        <div class="max-w-[1100px] mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-1">
                    <div class="mb-4">
                        <span style="font-size:22px; font-weight:900; color:#e53e3e;">BANGSA</span>
                        <span style="font-size:22px; font-weight:900; color:#fff;">BLOG</span>
                    </div>
                    <p class="text-gray-400 text-xs leading-relaxed">Portal berita dan blog profesional. Informatif, tajam, dan terpercaya.</p>
                </div>
                <div>
                    <h4 class="font-bold text-sm mb-4 uppercase tracking-wider text-gray-300">Kategori</h4>
                    <ul class="space-y-2">
                        @foreach(App\Models\Category::take(5)->get() as $cat)
                        <li><a href="{{ route('category.show', $cat->slug) }}" class="text-gray-400 text-xs hover:text-red-400 transition">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-sm mb-4 uppercase tracking-wider text-gray-300">Ikuti Kami</h4>
                    <ul class="space-y-2 text-gray-400 text-xs">
                        <li><a href="#" class="hover:text-red-400 transition">Instagram</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Twitter / X</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">TikTok</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">YouTube</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-sm mb-4 uppercase tracking-wider text-gray-300">Tentang</h4>
                    <ul class="space-y-2 text-gray-400 text-xs">
                        <li><a href="#" class="hover:text-red-400 transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} BANGSA Blog. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
