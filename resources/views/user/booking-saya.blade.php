@extends('layouts.layout')

@section('content')

<div class="flex">

    <x-sidenavbar />

    <div class="flex-1 ml-64 p-8">

        <h1 class="text-2xl font-bold mb-6">
            Booking Saya
        </h1>

        <div class="bg-white shadow rounded-xl p-6">

            <table class="w-full border">

                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Lapangan</th>
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">Jam</th>
                        <th class="border p-2">Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($bookings as $booking)

                        <tr>
                            <td class="border p-2">
                                {{ $booking->lapangan->nama_lapangan }}
                            </td>

                            <td class="border p-2">
                                {{ $booking->tanggal }}
                            </td>

                            <td class="border p-2">
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
                            <td colspan="4" class="text-center p-4">
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