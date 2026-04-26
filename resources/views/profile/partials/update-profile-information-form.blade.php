<section>
    <header class="mb-6">
        <h2 class="text-lg font-bold text-gray-900 tracking-tight">Informasi Akun</h2>
        <p class="mt-1 text-xs text-gray-500">Perbarui nama dan alamat email kamu.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Nama Lengkap</label>
            <input type="text" name="name" class="w-full bg-gray-50 border-none rounded-xl p-3.5 text-sm focus:ring-2 focus:ring-blue-500 transition-all outline-none" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-xs text-red-500" :messages="$errors->get('name')" />
        </div>

        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Alamat Email</label>
            <input type="email" name="email" class="w-full bg-gray-50 border-none rounded-xl p-3.5 text-sm focus:ring-2 focus:ring-blue-500 transition-all outline-none" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2 text-xs text-red-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 bg-amber-50 p-3 rounded-lg border border-amber-100 italic">
                    <p class="text-xs text-amber-800 flex items-center gap-2">
                        Email kamu belum terverifikasi.
                        <button form="send-verification" class="font-bold underline hover:text-amber-900">Klik di sini untuk kirim ulang.</button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-xs text-emerald-600">Link verifikasi baru telah dikirim ke email kamu.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-red-600 text-white font-bold px-6 py-2.5 rounded-lg hover:bg-red-700 transition text-xs uppercase tracking-widest">Simpan Perubahan</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs text-emerald-600 font-bold italic">Profil diperbarui!</p>
            @endif
        </div>
    </form>
</section>
