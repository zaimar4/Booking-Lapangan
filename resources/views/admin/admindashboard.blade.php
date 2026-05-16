@extends('layouts.layout')

@section('title', 'Dashboard Admin')

@section('content')

<div class="p-4 sm:p-6">

    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-500 mt-1 text-sm sm:text-base">Statistik booking dan pendapatan lapangan</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 mb-6 sm:mb-8">

        <div class="bg-white rounded-2xl shadow-md p-4 sm:p-5 border">
            <p class="text-gray-500 text-xs sm:text-sm">Total Lapangan</p>
            <h2 class="text-2xl sm:text-4xl font-bold text-green-600 mt-2 sm:mt-3">{{ $totalLapangan }}</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-4 sm:p-5 border">
            <p class="text-gray-500 text-xs sm:text-sm">Total Booking</p>
            <h2 class="text-2xl sm:text-4xl font-bold text-blue-600 mt-2 sm:mt-3">{{ $totalBookingSemua }}</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-4 sm:p-5 border">
            <p class="text-gray-500 text-xs sm:text-sm">Booking Pending</p>
            <h2 class="text-2xl sm:text-4xl font-bold text-yellow-500 mt-2 sm:mt-3">{{ $bookingPending }}</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-4 sm:p-5 border">
            <p class="text-gray-500 text-xs sm:text-sm">Total Pendapatan</p>
            <h2 class="text-xl sm:text-3xl font-bold text-purple-600 mt-2 sm:mt-3">
                Rp {{ number_format($totalPendapatanSemua, 0, ',', '.') }}
            </h2>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">

        <div class="bg-white rounded-2xl shadow-md p-4 sm:p-5 border">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700 mb-4 sm:mb-5">Grafik Total Booking</h2>
            {!! $bookingChart->container() !!}
        </div>

        <div class="bg-white rounded-2xl shadow-md p-4 sm:p-5 border">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700 mb-4 sm:mb-5">Grafik Pendapatan</h2>
            {!! $pendapatanChart->container() !!}
        </div>

    </div>

    <div class="bg-white shadow-md rounded-2xl overflow-hidden border">

        <div class="p-4 sm:p-5 border-b">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Booking Masuk</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-left text-gray-700">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">Pemesan</th>
                        <th class="px-4 py-3 whitespace-nowrap">Lapangan</th>
                        <th class="px-4 py-3 whitespace-nowrap">Jenis</th>
                        <th class="px-4 py-3 whitespace-nowrap">Tanggal</th>
                        <th class="px-4 py-3 whitespace-nowrap">Jam</th>
                        <th class="px-4 py-3 whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 whitespace-nowrap">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $item)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-4 py-3 font-medium whitespace-nowrap">
                            {{ $item->user->name ?? 'User' }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $item->lapangan->nama_lapangan }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="bg-gray-200 text-xs px-2 py-1 rounded">
                                {{ $item->lapangan->jenisLapangan->nama_jenis }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                            {{ $item->tanggal }}
                        </td>

                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                            {{ $item->jam_mulai }} - {{ $item->jam_selesai }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($item->status == 'pending')
                                <span class="bg-yellow-200 text-yellow-700 text-xs px-3 py-1 rounded-full">
                                    Pending
                                </span>
                            @elseif($item->status == 'confirmed')
                                <span class="bg-blue-200 text-blue-700 text-xs px-3 py-1 rounded-full">
                                    Dikonfirmasi
                                </span>
                            @elseif($item->status == 'completed')
                                <span class="bg-green-200 text-green-700 text-xs px-3 py-1 rounded-full">
                                    Selesai
                                </span>
                            @else
                                <span class="bg-red-200 text-red-700 text-xs px-3 py-1 rounded-full">
                                    Dibatalkan
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 font-semibold text-green-600 whitespace-nowrap">
    @php
        $durasi = \Carbon\Carbon::parse($item->jam_mulai)->diffInHours(\Carbon\Carbon::parse($item->jam_selesai));
    @endphp
    Rp{{ number_format($item->lapangan->harga_sewa * $durasi, 0, ',', '.') }}
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

        @if($bookings->hasPages())
            <div class="p-4">
                {{ $bookings->links() }}
            </div>
        @endif

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
{{ $bookingChart->script() }}
{{ $pendapatanChart->script() }}

@endsection
