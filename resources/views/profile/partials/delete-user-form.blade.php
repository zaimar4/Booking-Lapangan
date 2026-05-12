<section>
    <div class="mb-6">
        <h2 class="text-lg font-bold text-zinc-900">Hapus Akun</h2>
        <p class="text-sm text-zinc-500 mt-1">Setelah akun dihapus, semua data akan hilang secara permanen. Pastikan kamu sudah mengunduh data yang diperlukan sebelum melanjutkan.</p>
    </div>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-xl transition-colors">
        Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-zinc-900">Yakin ingin menghapus akun?</h2>
            <p class="mt-2 text-sm text-zinc-500">
                Semua data akun akan dihapus secara permanen. Masukkan password kamu untuk konfirmasi.
            </p>

            <div class="mt-6">
                <label for="password" class="block text-sm font-semibold text-zinc-700 mb-1.5 sr-only">Password</label>
                <input id="password" name="password" type="password"
                       placeholder="Password"
                       class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-400 bg-white">
                @if ($errors->userDeletion->get('password'))
                    <p class="mt-1.5 text-xs text-red-500">{{ implode(', ', $errors->userDeletion->get('password')) }}</p>
                @endif
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                        class="px-5 py-2.5 border border-zinc-200 text-zinc-600 text-sm font-semibold rounded-xl hover:bg-zinc-50 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-xl transition-colors">
                    Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>