@extends('layouts.layout')

@section('title', 'Booking Lapangan')

@section('content')

<div class="p-6 ml-60">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Booking Lapangan</h1>

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

    <div class="bg-white rounded-2xl shadow-md p-6">

        <form action="{{ route('booking.store') }}" method="POST">

            @csrf

            <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">Tanggal Booking</label>
                <input
                    type="date"
                    id="tanggal"
                    name="tanggal"
                    value="{{ old('tanggal', date('Y-m-d')) }}"
                    min="{{ date('Y-m-d') }}"
                    required
                    class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            <div class="mb-6">
                <label class="block mb-4 font-semibold text-gray-700">Pilih Jam Booking</label>

                <div id="slotContainer" class="grid grid-cols-3 md:grid-cols-5 gap-3">
                    @for($i = 8; $i < 22; $i++)
                        @php $jam = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                        <button
                            type="button"
                            data-jam="{{ $jam }}"
                            class="slot-btn border rounded-xl py-3 font-semibold transition hover:bg-blue-100">
                            {{ $jam }}
                        </button>
                    @endfor
                </div>

                <div class="flex gap-5 mt-5 text-sm flex-wrap">
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 bg-blue-500 rounded"></div>
                        <span>Dipilih</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 bg-red-500 rounded"></div>
                        <span>Sudah Dibooking</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 border rounded"></div>
                        <span>Tersedia</span>
                    </div>
                </div>
            </div>

            <div id="hiddenSlots"></div>

            <div class="bg-gray-100 rounded-2xl p-5 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500 text-sm">Durasi</p>
                        <h2 id="durasi" class="text-2xl font-bold">0 Jam</h2>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Harga</p>
                        <h2 id="harga" class="text-2xl font-bold text-green-600">Rp 0</h2>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-4 rounded-xl font-semibold">
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

    let selectedSlots = [];

    const CLASS_DEFAULT  = 'slot-btn border rounded-xl py-3 font-semibold transition hover:bg-blue-100';
    const CLASS_SELECTED = 'slot-btn border border-blue-500 rounded-xl py-3 font-semibold bg-blue-500 text-white';
    const CLASS_BOOKED   = 'slot-btn border border-red-500 rounded-xl py-3 font-semibold bg-red-500 text-white cursor-not-allowed';

    async function loadBookedSlots() {
        const tanggal = tanggalInput.value;
        if (!tanggal) return;

        try {
            const response    = await fetch(`/user/booking/slots/{{ $lapangan->id }}/${tanggal}`);
            const bookedSlots = await response.json();
            const buttons     = document.querySelectorAll('.slot-btn');

            buttons.forEach(btn => {
                btn.disabled  = false;
                btn.className = CLASS_DEFAULT;
            });

            selectedSlots = [];
            updateBooking();

            buttons.forEach(btn => {
                if (bookedSlots.includes(btn.dataset.jam)) {
                    btn.disabled  = true;
                    btn.className = CLASS_BOOKED;
                }
            });

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
                alert('Slot harus berurutan');
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
        hiddenSlots.innerHTML = selectedSlots
            .map(slot => `<input type="hidden" name="slots[]" value="${slot}">`)
            .join('');

        durasiText.innerText = selectedSlots.length + ' Jam';
        hargaText.innerText  = 'Rp ' + (selectedSlots.length * hargaPerJam).toLocaleString('id-ID');
    }

    tanggalInput.addEventListener('change', loadBookedSlots);
    loadBookedSlots();
</script>

@endsection