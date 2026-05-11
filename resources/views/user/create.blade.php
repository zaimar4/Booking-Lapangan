@extends('layouts.layout')

@section('title', 'Booking Lapangan')

@section('content')

<div class="p-6 ml-60">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Booking Lapangan
    </h1>

    @if(session('error'))

        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-5">
            {{ session('error') }}
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

        <form
            action="{{ route('booking.store') }}"
            method="POST">

            @csrf

            <input
                type="hidden"
                name="lapangan_id"
                value="{{ $lapangan->id }}">

            <div class="mb-6">

                <label class="block mb-2 font-semibold text-gray-700">
                    Tanggal Booking
                </label>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ old('tanggal', date('Y-m-d')) }}"
                    min="{{ date('Y-m-d') }}"
                    required
                    class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none">

            </div>

            <div class="mb-6">

                <label class="block mb-4 font-semibold text-gray-700">
                    Pilih Jam Booking
                </label>

                <div class="grid grid-cols-3 md:grid-cols-5 gap-3">

                    @for($i = 8; $i < 22; $i++)

                        @php

                            $jam =
                                str_pad(
                                    $i,
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                ) . ':00';

                            $isBooked = in_array($jam, $bookedSlots);

                        @endphp

                        <button
                            type="button"
                            data-jam="{{ $jam }}"
                            {{ $isBooked ? 'disabled' : '' }}
                            class="slot-btn border rounded-xl py-3 font-semibold transition

                            {{ $isBooked
                                ? 'bg-red-500 text-white cursor-not-allowed border-red-500'
                                : 'hover:bg-blue-100'
                            }}">

                            {{ $jam }}

                        </button>

                    @endfor

                </div>

                <div class="flex gap-5 mt-5 text-sm">

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

                        <p class="text-gray-500 text-sm">
                            Durasi
                        </p>

                        <h2
                            id="durasi"
                            class="text-2xl font-bold">

                            0 Jam

                        </h2>

                    </div>

                    <div>

                        <p class="text-gray-500 text-sm">
                            Total Harga
                        </p>

                        <h2
                            id="harga"
                            class="text-2xl font-bold text-green-600">

                            Rp 0

                        </h2>

                    </div>

                </div>

            </div>

            <button
                type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-4 rounded-xl font-semibold">

                Booking Sekarang

            </button>

        </form>

    </div>

</div>

<script>

    const hargaPerJam =
        {{ $lapangan->harga_sewa }};

    const buttons =
        document.querySelectorAll('.slot-btn');

    const hiddenSlots =
        document.getElementById('hiddenSlots');

    const durasiText =
        document.getElementById('durasi');

    const hargaText =
        document.getElementById('harga');

    let selectedSlots = [];

    buttons.forEach(button => {

        button.addEventListener('click', function () {

            if (this.disabled) {

                return;

            }

            const jam = this.dataset.jam;

            if (selectedSlots.includes(jam)) {

                selectedSlots =
                    selectedSlots.filter(
                        item => item !== jam
                    );

                this.classList.remove(
                    'bg-blue-500',
                    'text-white',
                    'border-blue-500'
                );

            } else {

                selectedSlots.push(jam);

                selectedSlots.sort();

                if (!isSequential(selectedSlots)) {

                    selectedSlots.pop();

                    alert(
                        'Slot harus berurutan'
                    );

                    return;

                }

                this.classList.add(
                    'bg-blue-500',
                    'text-white',
                    'border-blue-500'
                );

            }

            updateBooking();

        });

    });

    function isSequential(slots) {

        for (let i = 0; i < slots.length - 1; i++) {

            let current =
                parseInt(
                    slots[i].split(':')[0]
                );

            let next =
                parseInt(
                    slots[i + 1].split(':')[0]
                );

            if (next !== current + 1) {

                return false;

            }

        }

        return true;

    }

    function updateBooking() {

        hiddenSlots.innerHTML = '';

        selectedSlots.forEach(slot => {

            hiddenSlots.innerHTML += `
                <input
                    type="hidden"
                    name="slots[]"
                    value="${slot}">
            `;

        });

        durasiText.innerText =
            selectedSlots.length + ' Jam';

        const total =
            selectedSlots.length *
            hargaPerJam;

        hargaText.innerText =
            'Rp ' +
            total.toLocaleString('id-ID');

    }

</script>

@endsection
