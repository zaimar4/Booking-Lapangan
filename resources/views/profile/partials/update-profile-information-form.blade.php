<section>
    <div class="mb-6">
        <h2 class="text-lg font-bold text-zinc-900">Informasi Profile</h2>
        <p class="text-sm text-zinc-500 mt-1">Perbarui nama dan alamat email akun kamu.</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-zinc-700 mb-1.5">Nama</label>
            <input id="name" name="name" type="text" required autofocus autocomplete="name"
                   value="{{ old('name', $user->name) }}"
                   class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white">
            @if ($errors->get('name'))
                <p class="mt-1.5 text-xs text-red-500">{{ implode(', ', $errors->get('name')) }}</p>
            @endif
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-zinc-700 mb-1.5">Email</label>
            <input id="email" name="email" type="email" required autocomplete="username"
                   value="{{ old('email', $user->email) }}"
                   class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white">
            @if ($errors->get('email'))
                <p class="mt-1.5 text-xs text-red-500">{{ implode(', ', $errors->get('email')) }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-amber-50 border border-amber-200 rounded-xl">
                    <p class="text-sm text-amber-700">
                        Email kamu belum terverifikasi.
                        <button form="send-verification" class="underline font-semibold hover:text-amber-900">
                            Kirim ulang email verifikasi.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 text-sm font-semibold text-green-600">Link verifikasi baru sudah dikirim.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-3 pt-1">
            <button type="submit"
                    class="px-6 py-2.5 bg-zinc-900 hover:bg-zinc-700 text-white text-sm font-bold rounded-xl transition-colors">
                Simpan
            </button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600 font-medium">Tersimpan!</p>
            @endif
        </div>
    </form>
</section>