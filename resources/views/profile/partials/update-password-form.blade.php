<section>
    <div class="mb-6">
        <h2 class="text-lg font-bold text-zinc-900">Ubah Password</h2>
        <p class="text-sm text-zinc-500 mt-1">Gunakan password yang panjang dan acak agar akun tetap aman.</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        {{-- Password Saat Ini --}}
        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-zinc-700 mb-1.5">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password"
                   autocomplete="current-password"
                   class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white">
            @if ($errors->updatePassword->get('current_password'))
                <p class="mt-1.5 text-xs text-red-500">{{ implode(', ', $errors->updatePassword->get('current_password')) }}</p>
            @endif
        </div>

        {{-- Password Baru --}}
        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-zinc-700 mb-1.5">Password Baru</label>
            <input id="update_password_password" name="password" type="password"
                   autocomplete="new-password"
                   class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white">
            @if ($errors->updatePassword->get('password'))
                <p class="mt-1.5 text-xs text-red-500">{{ implode(', ', $errors->updatePassword->get('password')) }}</p>
            @endif
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-zinc-700 mb-1.5">Konfirmasi Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                   autocomplete="new-password"
                   class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white">
            @if ($errors->updatePassword->get('password_confirmation'))
                <p class="mt-1.5 text-xs text-red-500">{{ implode(', ', $errors->updatePassword->get('password_confirmation')) }}</p>
            @endif
        </div>

        <div class="flex items-center gap-3 pt-1">
            <button type="submit"
                    class="px-6 py-2.5 bg-zinc-900 hover:bg-zinc-700 text-white text-sm font-bold rounded-xl transition-colors">
                Simpan
            </button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600 font-medium">Tersimpan!</p>
            @endif
        </div>
    </form>
</section>