<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — SportField</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4">

    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 rounded-2xl overflow-hidden shadow-lg border border-gray-200">

        {{-- ===== LEFT PANEL (Green) ===== --}}
        <div class="hidden lg:flex flex-col justify-between bg-green-600 p-12 relative overflow-hidden">

            {{-- Diagonal stripe texture --}}
            <div class="absolute inset-0"
                 style="background-image: repeating-linear-gradient(135deg, rgba(255,255,255,0.04) 0px, rgba(255,255,255,0.04) 1px, transparent 1px, transparent 24px);"></div>

            {{-- Decorative circles --}}
            <div class="absolute -bottom-20 -right-20 w-64 h-64 rounded-full bg-green-500 opacity-50"></div>
            <div class="absolute bottom-16 right-12 w-24 h-24 rounded-full bg-green-400 opacity-30"></div>
            <div class="absolute top-32 -left-10 w-32 h-32 rounded-full bg-green-700 opacity-40"></div>

            {{-- Brand --}}
            <div class="relative z-10 flex items-center gap-3">
                <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                    </svg>
                </div>
                <span class="font-display text-white text-xl font-bold tracking-tight">SportField</span>
            </div>

            {{-- Main content --}}
            <div class="relative z-10 space-y-8">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 bg-white/15 border border-white/25 text-white/90 text-xs font-semibold tracking-widest uppercase px-3.5 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-300 inline-block"></span>
                        Selamat Datang Kembali
                    </div>
                    <h1 class="font-display text-white text-4xl xl:text-[44px] font-extrabold leading-[1.15]">
                        Siap Booking<br>Lapangan<br><span class="text-green-200">Hari Ini?</span>
                    </h1>
                    <p class="text-green-100/80 text-sm leading-relaxed max-w-[280px]">
                        Masuk ke akunmu dan langsung temukan lapangan olahraga yang kamu suka di <span class="font-bold text-white text-lg">SportField</span>
                    </p>
                </div>

            </div>

            <div class="relative z-10 grid grid-cols-3 gap-4 pt-8 border-t border-white/20">
                @php
                    $stats=[
                    ['+'.App\Models\User::count(),'Pengguna Aktif'],
                    ['+' . App\Models\lapangan::count(), 'Total Lapangan'],
                    ['+' . App\Models\Booking::count(), 'Bookings']
                    ]
                @endphp
                @foreach($stats as $s)
                <div>
                    <p class="font-display text-white text-2xl font-extrabold">{{ $s[0] }}</p>
                    <p class="text-green-200/80 text-xs mt-0.5">{{ $s[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white p-8 lg:p-12 flex flex-col justify-center min-h-[580px]">

            <div class="flex lg:hidden items-center gap-2.5 mb-8">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                    </svg>
                </div>
                <span class="font-display text-gray-900 text-lg font-bold">SportField</span>
            </div>

            {{-- Heading --}}
            <div class="mb-7">
                <h2 class="font-display text-gray-900 text-2xl font-bold">Masuk ke Akun</h2>
                <p class="text-gray-500 text-sm mt-1.5">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-semibold transition-colors">Daftar gratis</a>
                </p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-5 flex items-start gap-2.5 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3">
                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username" placeholder="nama@email.com"
                           class="w-full border border-gray-300 bg-white text-gray-900 placeholder-gray-400 rounded-lg px-3.5 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all
                                  @error('email') border-red-400 bg-red-50 @enderror">
                    @error('email')<p class="mt-1 text-xs text-red-500 flex items-center gap-1"><svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-green-600 hover:text-green-700 font-medium transition-colors">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password" placeholder="Masukkan password"
                           class="w-full border border-gray-300 bg-white text-gray-900 placeholder-gray-400 rounded-lg px-3.5 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all
                                  @error('password') border-red-400 bg-red-50 @enderror">
                    @error('password')<p class="mt-1 text-xs text-red-500 flex items-center gap-1"><svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
                </div>

                {{-- Remember me --}}
                <label for="remember_me" class="flex items-center gap-2.5 cursor-pointer select-none group">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 focus:ring-offset-1 cursor-pointer transition-colors">
                    <span class="text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Ingat saya di perangkat ini</span>
                </label>

                {{-- Submit --}}
                <div class="pt-1">
                    <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 active:bg-green-800 text-white font-semibold text-sm py-3 rounded-lg
                                   transition-colors duration-150 shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Masuk Sekarang
                    </button>
                </div>
            </form>


            {{-- Footer --}}
            <p class="text-center text-gray-400 text-xs mt-8">
                © {{ date('Y') }} SportField. Hak cipta dilindungi.
            </p>
        </div>

    </div>

</body>
</html>