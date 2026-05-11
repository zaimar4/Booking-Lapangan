@extends('layouts.layout')

@section('title', 'Dashboard Admin')

@section('content')

<div class="p-6 ml-60">

    <!-- HEADER -->
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Dashboard Admin
    </h1>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <div class="bg-white rounded-2xl shadow p-5 border">
            <p class="text-gray-500 text-sm">Total Lapangan</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">
                {{ $totalLapangan }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-5 border">
            <p class="text-gray-500 text-sm">Total Booking</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">
                {{ $totalBooking ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-5 border">
            <p class="text-gray-500 text-sm">Booking Pending</p>
            <h2 class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $bookingpending ?? 0 }}
            </h2>
        </div>

    </div>

    <div class="bg-white shadow-md rounded-2xl overflow-hidden">

        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-700">
                Booking Masuk (Pending)
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-100 text-left text-gray-700">
                    <tr>
                        <th class="px-4 py-3">Pemesan</th>
                        <th class="px-4 py-3">Lapangan</th>
                        <th class="px-4 py-3">Jenis</th>
                        <th class="px-4 py-3">Tanggal Booking</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
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

                        <td class="px-4 py-3 text-gray-600 text-sm">
                            {{ $item->tanggal_booking ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="bg-yellow-200 text-yellow-700 text-xs px-2 py-1 rounded">
                                {{ $item->status }}
                            </span>
                        </td>

                        <td class="px-4 py-3 flex gap-2">

                            <!-- DETAIL -->
                            {{-- <a href="{{ route('detail-booking', $item->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                Detail
                            </a>

                            <!-- APPROVE -->
                            <a href="{{ route('approve-booking', $item->id) }}"
                               class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                Approve
                            </a> --}}

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            Tidak ada booking masuk
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection