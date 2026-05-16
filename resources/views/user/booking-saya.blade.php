@extends('layouts.layout')

@section('content')

<div class="p-4 sm:p-8">

    <h1 class="text-xl sm:text-2xl font-bold mb-5 sm:mb-6">
        Booking Saya
    </h1>

    <div class="bg-white shadow rounded-xl p-4 sm:p-6">
        <div class="overflow-x-auto">
            <table class="w-full border text-sm">

                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 whitespace-nowrap text-left">Lapangan</th>
                        <th class="border p-2 whitespace-nowrap text-left">Tanggal</th>
                        <th class="border p-2 whitespace-nowrap text-left">Jam</th>
                        <th class="border p-2 whitespace-nowrap text-left">Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($bookings as $booking)

                        <tr>
                            <td class="border p-2">
                                {{ $booking->lapangan->nama_lapangan }}
                            </td>

                            <td class="border p-2 whitespace-nowrap">
                                {{ $booking->tanggal }}
                            </td>

                            <td class="border p-2 whitespace-nowrap">
                                {{ $booking->jam_mulai }}
                                -
                                {{ $booking->jam_selesai }}
                            </td>

                            <td class="border p-2">
                                {{ $booking->status }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center p-4 text-gray-500">
                                Belum ada booking
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
