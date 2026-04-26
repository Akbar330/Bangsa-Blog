<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-red-600 tracking-tight">Hapus Akun</h2>
        <p class="mt-1 text-xs text-gray-500">Sekali akun kamu dihapus, semua data akan hilang secara permanen. Mohon berhati-hati.</p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-xl transition duration-200 text-xs uppercase tracking-widest shadow-lg shadow-red-100 border-none"
    >{{ __('Hapus Akun Saya') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900">
                Apakah kamu yakin ingin menghapus akun?
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Silakan masukkan password kamu untuk mengonfirmasi bahwa kamu benar-benar ingin menghapus akun secara permanen.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Password</label>
                <input id="password" name="password" type="password" class="w-full bg-gray-50 border-none rounded-xl p-4 text-sm focus:ring-2 focus:ring-red-500 outline-none" placeholder="Password Kamu" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-xs text-red-500" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-6 py-3 rounded-xl border-none text-xs uppercase tracking-widest transition">
                    Batal
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-3 rounded-xl border-none text-xs uppercase tracking-widest shadow-lg shadow-red-100 transition">
                    Ya, Hapus Permanen
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
