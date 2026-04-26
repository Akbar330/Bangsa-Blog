<section>
    <header class="mb-6">
        <h2 class="text-lg font-bold text-gray-900 tracking-tight">Ganti Kata Sandi</h2>
        <p class="mt-1 text-xs text-gray-500">Gunakan password yang kuat agar akun kamu tetap aman.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Password Saat Ini</label>
            <input type="password" name="current_password" class="w-full bg-gray-50 border-none rounded-xl p-3.5 text-sm focus:ring-2 focus:ring-blue-500 transition-all outline-none" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs text-red-500" />
        </div>

        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Password Baru</label>
            <input type="password" name="password" class="w-full bg-gray-50 border-none rounded-xl p-3.5 text-sm focus:ring-2 focus:ring-blue-500 transition-all outline-none" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs text-red-500" />
        </div>

        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full bg-gray-50 border-none rounded-xl p-3.5 text-sm focus:ring-2 focus:ring-blue-500 transition-all outline-none" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs text-red-500" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-gray-900 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-black transition text-xs uppercase tracking-widest">Ganti Password</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs text-emerald-600 font-bold italic">Berhasil diubah!</p>
            @endif
        </div>
    </form>
</section>
