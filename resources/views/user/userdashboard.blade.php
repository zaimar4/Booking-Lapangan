@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
<<<<<<< HEAD
<div class="flex">
    <x-sidenavbar />
=======
>>>>>>> b2fad64ad5c5a64821639ffebb3a65d100d908a7

    <div class="flex-1 p-8 ml-64">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-900">Halo, {{ Auth::user()->name }}</h1>
            <p class="text-zinc-500 text-sm mt-1">Selamat datang di aplikasi booking lapangan</p>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="bg-white border border-zinc-200 rounded-xl px-5 py-4">
                <p class="text-xs text-zinc-400 font-medium">Total Booking</p>
                <p class="text-2xl font-bold text-zinc-900 mt-1">{{ $totalBooking }}</p>
            </div>
            <div class="bg-yellow-50 border border-yellow-100 rounded-xl px-5 py-4">
                <p class="text-xs text-yellow-600 font-medium">Menunggu Konfirmasi</p>
                <p class="text-2xl font-bold text-yellow-700 mt-1">{{ $totalPending }}</p>
            </div>
            <div class="bg-blue-50 border border-blue-100 rounded-xl px-5 py-4">
                <p class="text-xs text-blue-600 font-medium">Dikonfirmasi</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $totalConfirmed }}</p>
            </div>
            <div class="bg-green-50 border border-green-100 rounded-xl px-5 py-4">
                <p class="text-xs text-green-600 font-medium">Selesai</p>
                <p class="text-2xl font-bold text-green-700 mt-1">{{ $totalCompleted }}</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">

            {{-- Booking Terbaru --}}
            <div class="col-span-2 bg-white border border-zinc-200 rounded-xl overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-100">
                    <h2 class="font-semibold text-zinc-900">Booking Terbaru</h2>
                    <a href="{{ route('booking.index') }}" class="text-xs text-zinc-400 hover:text-zinc-700">Lihat semua →</a>
                </div>

                @forelse($bookingTerbaru as $booking)
                    @php
                        $statusColor = match($booking->status) {
                            'pending'   => 'bg-yellow-100 text-yellow-700',
                            'confirmed' => 'bg-blue-100 text-blue-700',
                            'completed' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            default     => 'bg-zinc-100 text-zinc-600',
                        };
                        $statusLabel = match($booking->status) {
                            'pending'   => 'Menunggu',
                            'confirmed' => 'Dikonfirmasi',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            default     => $booking->status,
                        };
                    @endphp
                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-zinc-50 last:border-b-0 hover:bg-zinc-50 transition-colors">
                        <div>
                            <p class="text-sm font-medium text-zinc-900">{{ $booking->lapangan->nama_lapangan }}</p>
                            <p class="text-xs text-zinc-400 mt-0.5">
                                {{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}
                                · {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                            </p>
                        </div>
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center text-zinc-400 text-sm">
                        Belum ada booking
                    </div>
                @endforelse
            </div>

            {{-- Shortcut --}}
            <div class="flex flex-col gap-4">
                <div class="bg-white border border-zinc-200 rounded-xl p-5">
                    <h2 class="font-semibold text-zinc-900 mb-4">Menu Cepat</h2>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('user.cari-lapangan') }}"
                           class="flex items-center gap-3 px-4 py-3 bg-zinc-900 text-white rounded-lg hover:bg-zinc-700 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Cari Lapangan
                        </a>
                        <a href="{{ route('booking.index') }}"
                           class="flex items-center gap-3 px-4 py-3 bg-white border border-zinc-200 text-zinc-700 rounded-lg hover:bg-zinc-50 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Booking Saya
                        </a>
                    </div>
                </div>

                {{-- Info booking dikonfirmasi --}}
                @if($totalConfirmed > 0)
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
                        <p class="text-sm font-semibold text-blue-700">🎉 Ada {{ $totalConfirmed }} booking dikonfirmasi!</p>
                        <p class="text-xs text-blue-500 mt-1">Booking kamu sudah siap. Jangan lupa datang tepat waktu.</p>
                        <a href="{{ route('booking.index', ['status' => 'confirmed']) }}"
                           class="inline-block mt-3 text-xs font-medium text-blue-700 underline">
                            Lihat detail →
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection