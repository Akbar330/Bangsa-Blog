<x-guest-layout>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-black text-gray-900">Masuk ke BANGSA BLOG</h2>
            <p class="text-sm text-gray-500 mt-1">Ikuti berita terbaru dan berdiskusi bersama pembaca lain</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-sm text-green-600 font-semibold bg-green-50 p-3 rounded-lg" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition bg-gray-50 hover:bg-white" placeholder="email@kamu.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500" />
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition bg-gray-50 hover:bg-white" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                    <span class="text-xs font-medium text-gray-600">Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-red-600 hover:underline">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-lg hover:bg-red-700 transition text-sm mt-2">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-red-600 font-bold hover:underline ml-1">Daftar Gratis</a>
            </p>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-red-600 transition">&larr; Kembali ke Beranda</a>
        </div>
    </div>
</x-guest-layout>
