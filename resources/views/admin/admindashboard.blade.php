@extends('layouts.layout')

@section('title', 'Dashboard Admin')

@section('content')

<div class="p-6 ml-60">

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">
            Dashboard Admin
        </h1>

        <p class="text-gray-500 mt-1">
            Statistik booking dan pendapatan lapangan
        </p>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        <div class="bg-white rounded-2xl shadow-md p-5 border">

            <p class="text-gray-500 text-sm">
                Total Lapangan
            </p>

            <h2 class="text-4xl font-bold text-green-600 mt-3">

                {{ $totalLapangan }}

            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow-md p-5 border">

            <p class="text-gray-500 text-sm">
                Total Booking
            </p>

            <h2 class="text-4xl font-bold text-blue-600 mt-3">

                {{ $totalBookingSemua }}

            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow-md p-5 border">

            <p class="text-gray-500 text-sm">
                Booking Pending
            </p>

            <h2 class="text-4xl font-bold text-yellow-500 mt-3">

                {{ $bookingPending }}

            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow-md p-5 border">

            <p class="text-gray-500 text-sm">
                Total Pendapatan
            </p>

            <h2 class="text-3xl font-bold text-purple-600 mt-3">

                Rp {{ number_format($totalPendapatanSemua, 0, ',', '.') }}

            </h2>

        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <div class="bg-white rounded-2xl shadow-md p-5 border">

            <h2 class="text-lg font-semibold text-gray-700 mb-5">
                Grafik Total Booking
            </h2>

            {!! $bookingChart->container() !!}

        </div>

        <div class="bg-white rounded-2xl shadow-md p-5 border">

            <h2 class="text-lg font-semibold text-gray-700 mb-5">
                Grafik Pendapatan
            </h2>

            {!! $pendapatanChart->container() !!}

        </div>

    </div>

    <div class="bg-white shadow-md rounded-2xl overflow-hidden border">

        <div class="p-5 border-b">

            <h2 class="text-lg font-semibold text-gray-700">
                Booking Masuk
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-100 text-left text-gray-700">

                    <tr>

                        <th class="px-4 py-3">
                            Pemesan
                        </th>

                        <th class="px-4 py-3">
                            Lapangan
                        </th>

                        <th class="px-4 py-3">
                            Jenis
                        </th>

                        <th class="px-4 py-3">
                            Tanggal
                        </th>

                        <th class="px-4 py-3">
                            Jam
                        </th>

                        <th class="px-4 py-3">
                            Status
                        </th>

                        <th class="px-4 py-3">
                            Total
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse ($bookings as $item)

                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-4 py-3 font-medium">

                            {{ $item->user->name ?? 'User' }}

                        </td>

                        <td class="px-4 py-3">

                            {{ $item->lapangan->nama_lapangan }}

                        </td>

                        <td class="px-4 py-3">

                            <span class="bg-gray-200 text-xs px-2 py-1 rounded">

                                {{ $item->lapangan->jenisLapangan->nama_jenis }}

                            </span>

                        </td>

                        <td class="px-4 py-3 text-gray-600">

                            {{ $item->tanggal }}

                        </td>

                        <td class="px-4 py-3 text-gray-600">

                            {{ $item->jam_mulai }}
                            -
                            {{ $item->jam_selesai }}

                        </td>

                        <td class="px-4 py-3">

                            @if($item->status == 'pending')

                                <span class="bg-yellow-200 text-yellow-700 text-xs px-3 py-1 rounded-full">

                                    Pending

                                </span>

                            @elseif($item->status == 'approved')

                                <span class="bg-green-200 text-green-700 text-xs px-3 py-1 rounded-full">

                                    Approved

                                </span>

                            @else

                                <span class="bg-red-200 text-red-700 text-xs px-3 py-1 rounded-full">

                                    Ditolak

                                </span>

                            @endif

                        </td>

                        <td class="px-4 py-3 font-semibold text-green-600">

                            Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="text-center py-8 text-gray-500">

                            Tidak ada booking masuk

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

{{ $bookingChart->script() }}

{{ $pendapatanChart->script() }}

@endsection
