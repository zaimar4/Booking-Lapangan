@extends('layouts.layout')

@section('title', 'Booking Lapangan')

@section('content')

<div class="p-4 sm:p-6">

    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-5 sm:mb-6">Booking Lapangan</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-5">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-5">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-5">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Info lapangan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-zinc-100 p-4 sm:p-5 mb-4 flex items-center gap-4">
        @if($lapangan->gambar_lapangan)
            <img src="{{  $lapangan->gambar_lapangan }}"
                 class="w-16 h-16 rounded-xl object-cover flex-shrink-0" alt="{{ $lapangan->nama_lapangan }}">
        @endif
        <div>
            <h2 class="font-bold text-zinc-900 text-base">{{ $lapangan->nama_lapangan }}</h2>
            <p class="text-sm text-zinc-500 mt-0.5">
                Jam Operasional:
                <span class="font-semibold text-zinc-700">
                    {{ \Illuminate\Support\Str::substr($lapangan->jam_buka, 0, 5) }} – {{ \Illuminate\Support\Str::substr($lapangan->jam_tutup, 0, 5) }}
                </span>
            </p>
            <p class="text-sm text-green-600 font-semibold mt-0.5">
                Rp{{ number_format($lapangan->harga_sewa, 0, ',', '.') }} / jam
            </p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-4 sm:p-6">

        <form action="{{ route('booking.store') }}" method="POST">

            @csrf

            <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

            <div class="mb-5 sm:mb-6">
                <label class="block mb-2 font-semibold text-gray-700 text-sm sm:text-base">Tanggal Booking</label>
                <input
                    type="date"
                    id="tanggal"
                    name="tanggal"
                    value="{{ old('tanggal', date('Y-m-d')) }}"
                    min="{{ date('Y-m-d') }}"
                    required
                    class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm sm:text-base">
            </div>

            <div class="mb-5 sm:mb-6">
                <label class="block mb-3 sm:mb-4 font-semibold text-gray-700 text-sm sm:text-base">Pilih Jam Booking</label>

                {{--
                    Slot dirender dari $availableSlots yang dikirim controller
                    (sudah sesuai jam_buka s/d jam_tutup lapangan).
                    Slot yang sudah lewat (hari ini) dinonaktifkan via JS setelah render.
                --}}
                <div id="slotContainer" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-7 gap-2 sm:gap-3">
                    @foreach($availableSlots as $jam)
                        <button
                            type="button"
                            data-jam="{{ $jam }}"
                            class="slot-btn border rounded-xl py-2.5 sm:py-3 text-sm font-semibold transition hover:bg-blue-100">
                            {{ $jam }}
                        </button>
                    @endforeach
                </div>

                {{-- Jika tidak ada slot sama sekali (lapangan tutup / jam_buka == jam_tutup) --}}
                @if(empty($availableSlots))
                    <p class="text-sm text-zinc-500 mt-3">Tidak ada slot tersedia untuk lapangan ini.</p>
                @endif

                <div class="flex flex-wrap gap-3 sm:gap-5 mt-4 sm:mt-5 text-xs sm:text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 bg-blue-500 rounded"></div>
                        <span>Dipilih</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 bg-red-500 rounded"></div>
                        <span>Sudah Dibooking</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 bg-zinc-300 rounded"></div>
                        <span>Sudah Lewat</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 border rounded"></div>
                        <span>Tersedia</span>
                    </div>
                </div>
            </div>

            <div id="hiddenSlots"></div>

            <div class="bg-gray-100 rounded-2xl p-4 sm:p-5 mb-5 sm:mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500 text-xs sm:text-sm">Durasi</p>
                        <h2 id="durasi" class="text-xl sm:text-2xl font-bold">0 Jam</h2>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs sm:text-sm">Total Harga</p>
                        <h2 id="harga" class="text-xl sm:text-2xl font-bold text-green-600">Rp 0</h2>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 sm:py-4 rounded-xl font-semibold text-sm sm:text-base transition-colors">
                Booking Sekarang
            </button>

        </form>

    </div>

</div>

<script>
    const hargaPerJam  = {{ $lapangan->harga_sewa }};
    const tanggalInput = document.getElementById('tanggal');
    const hiddenSlots  = document.getElementById('hiddenSlots');
    const durasiText   = document.getElementById('durasi');
    const hargaText    = document.getElementById('harga');

    // Jam sekarang (server-side agar konsisten dengan timezone aplikasi)
    const nowHour      = {{ (int) now()->format('H') }};
    const todayStr     = '{{ now()->toDateString() }}';

    let selectedSlots = [];

    const CLASS_DEFAULT  = 'slot-btn border rounded-xl py-2.5 sm:py-3 text-sm font-semibold transition hover:bg-blue-100';
    const CLASS_SELECTED = 'slot-btn border border-blue-500 rounded-xl py-2.5 sm:py-3 text-sm font-semibold bg-blue-500 text-white';
    const CLASS_BOOKED   = 'slot-btn border border-red-500 rounded-xl py-2.5 sm:py-3 text-sm font-semibold bg-red-500 text-white cursor-not-allowed';
    const CLASS_PAST     = 'slot-btn border border-zinc-300 rounded-xl py-2.5 sm:py-3 text-sm font-semibold bg-zinc-200 text-zinc-400 cursor-not-allowed';

    function markPastSlots() {
        const isToday = tanggalInput.value === todayStr;
        const buttons = document.querySelectorAll('.slot-btn');

        buttons.forEach(btn => {
            // Jangan sentuh slot yang sudah dibooking (merah)
            if (btn.dataset.status === 'booked') return;

            const slotHour = parseInt(btn.dataset.jam);

            if (isToday && slotHour <= nowHour) {
                btn.disabled    = true;
                btn.className   = CLASS_PAST;
                btn.title       = 'Jam ini sudah lewat';
                // Kalau slot ini terlanjur dipilih, hapus dari selectedSlots
                selectedSlots   = selectedSlots.filter(s => s !== btn.dataset.jam);
            } else if (!btn.dataset.status) {
                btn.disabled    = false;
                btn.className   = CLASS_DEFAULT;
                btn.title       = '';
            }
        });

        updateBooking();
    }

    async function loadBookedSlots() {
        const tanggal = tanggalInput.value;
        if (!tanggal) return;

        try {
            const response    = await fetch(`/user/booking/slots/{{ $lapangan->id }}/${tanggal}`);
            const bookedSlots = await response.json();
            const buttons     = document.querySelectorAll('.slot-btn');

            // Reset semua slot dulu
            buttons.forEach(btn => {
                delete btn.dataset.status;
                btn.disabled  = false;
                btn.className = CLASS_DEFAULT;
                btn.title     = '';
            });

            selectedSlots = [];

            // Tandai slot yang sudah dibooking
            buttons.forEach(btn => {
                if (bookedSlots.includes(btn.dataset.jam)) {
                    btn.disabled        = true;
                    btn.className       = CLASS_BOOKED;
                    btn.dataset.status  = 'booked';
                    btn.title           = 'Sudah dibooking';
                }
            });

            // Tandai slot yang sudah lewat (harus setelah booked agar tidak override)
            markPastSlots();

        } catch (error) {
            console.error(error);
        }
    }

    document.addEventListener('click', function (e) {
        if (!e.target.classList.contains('slot-btn')) return;

        const button = e.target;
        if (button.disabled) return;

        const jam = button.dataset.jam;

        if (selectedSlots.includes(jam)) {
            selectedSlots     = selectedSlots.filter(s => s !== jam);
            button.className  = CLASS_DEFAULT;
        } else {
            const temp = [...selectedSlots, jam].sort();

            if (!isSequential(temp)) {
                alert('Slot harus berurutan! Pilih jam yang sambung-menyambung.');
                return;
            }

            selectedSlots    = temp;
            button.className = CLASS_SELECTED;
        }

        updateBooking();
    });

    function isSequential(slots) {
        for (let i = 0; i < slots.length - 1; i++) {
            if (parseInt(slots[i + 1]) !== parseInt(slots[i]) + 1) return false;
        }
        return true;
    }

    function updateBooking() {
        // Sinkronkan warna selected slot (bisa berubah setelah reset)
        document.querySelectorAll('.slot-btn').forEach(btn => {
            if (btn.dataset.status === 'booked' || btn.disabled) return;
            btn.className = selectedSlots.includes(btn.dataset.jam) ? CLASS_SELECTED : CLASS_DEFAULT;
        });

        hiddenSlots.innerHTML = selectedSlots
            .map(slot => `<input type="hidden" name="slots[]" value="${slot}">`)
            .join('');

        durasiText.innerText = selectedSlots.length + ' Jam';
        hargaText.innerText  = 'Rp ' + (selectedSlots.length * hargaPerJam).toLocaleString('id-ID');
    }

    tanggalInput.addEventListener('change', loadBookedSlots);

    // Jalankan saat pertama load
    loadBookedSlots();
</script>

@endsection