@extends('layouts.layout')

@section('title', 'Booking Saya')

@section('content')
<div class="p-4 sm:p-8">

    <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 mb-1">Booking Saya</h1>
    <p class="text-zinc-500 text-sm mb-5 sm:mb-6">Pantau status booking lapangan kamu</p>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    @php
        $tabs = ['semua' => 'Semua', 'pending' => 'Pending', 'confirmed' => 'Dikonfirmasi', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
        $active = request('status', 'semua');
    @endphp
    <div class="flex flex-wrap gap-2 mb-5">
        @foreach($tabs as $key => $label)
            <a href="{{ route('booking.index', $key !== 'semua' ? ['status' => $key] : []) }}"
               class="px-3 sm:px-4 py-1.5 rounded-full text-xs sm:text-sm font-medium border transition-colors
               {{ $active === $key ? 'bg-zinc-900 text-white border-zinc-900' : 'bg-white text-zinc-600 border-zinc-200 hover:border-zinc-400' }}">
                {{ $label }}
                @if($key !== 'semua' && ($counts[$key] ?? 0) > 0)
                    <span class="ml-1 text-xs opacity-60">({{ $counts[$key] }})</span>
                @endif
            </a>
        @endforeach
    </div>

    @forelse($bookings as $booking)
        @php
            $durasi = \Carbon\Carbon::parse($booking->jam_mulai)->diffInHours(\Carbon\Carbon::parse($booking->jam_selesai));
            $statusColor = match($booking->status) {
                'pending'   => 'bg-yellow-100 text-yellow-700',
                'confirmed' => 'bg-blue-100 text-blue-700',
                'completed' => 'bg-green-100 text-green-700',
                'cancelled' => 'bg-red-100 text-red-700',
                default     => 'bg-zinc-100 text-zinc-600',
            };
            $statusLabel = match($booking->status) {
                'pending'   => 'Menunggu Konfirmasi',
                'confirmed' => 'Dikonfirmasi ✓',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                default     => $booking->status,
            };
        @endphp

        <div class="bg-white border border-zinc-200 rounded-xl mb-3 overflow-hidden">

            @if($booking->status === 'confirmed')
                <div class="px-4 sm:px-5 py-2 bg-blue-50 border-b border-blue-100 text-sm text-blue-700 font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Booking kamu sudah dikonfirmasi oleh admin!
                </div>
            @endif

            <div class="flex items-start sm:items-center gap-3 sm:gap-4 p-3 sm:p-4">
                @if($booking->lapangan->gambar_lapangan)
                    <img src="{{ asset('images/' . $booking->lapangan->gambar_lapangan) }}"
                         class="w-16 h-14 sm:w-20 sm:h-16 object-cover rounded-lg shrink-0">
                @endif

                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="font-semibold text-zinc-900 text-sm sm:text-base truncate">{{ $booking->lapangan->nama_lapangan }}</p>
                            <p class="text-xs text-zinc-400">{{ $booking->lapangan->jenisLapangan->nama_jenis ?? '-' }}</p>
                        </div>
                        <span class="text-xs font-medium px-2 sm:px-2.5 py-1 rounded-full {{ $statusColor }} shrink-0">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-x-3 sm:gap-x-4 gap-y-1 mt-2 text-xs sm:text-sm text-zinc-600">
                        <span>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}</span>
                        <span>{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }} ({{ $durasi }}j)</span>
                        <span class="text-green-600 font-medium">Rp{{ number_format($booking->lapangan->harga_sewa * $durasi, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between px-3 sm:px-4 py-2.5 bg-zinc-50 border-t border-zinc-100">
                <span class="text-xs text-zinc-400">{{ $booking->created_at->diffForHumans() }}</span>
                <div class="flex gap-2">
                    @if($booking->status === 'pending')
                        <form action="{{ route('booking.destroy', $booking->id) }}" method="POST"
                              onsubmit="return confirm('Yakin batalkan booking ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1.5 text-xs font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50">
                                Batalkan
                            </button>
                        </form>
                    @endif
                    @if(in_array($booking->status, ['completed', 'cancelled']))
                        <a href="{{ route('booking.create', $booking->lapangan->id) }}"
                           class="px-3 py-1.5 text-xs font-medium text-zinc-700 bg-white border border-zinc-200 rounded-lg hover:bg-zinc-50">
                            Booking Lagi
                        </a>
                    @endif
                </div>
            </div>
        </div>

    @empty
        <div class="flex flex-col items-center justify-center py-12 sm:py-16 bg-white border border-zinc-200 rounded-xl text-center px-4">
            <p class="text-zinc-500 font-medium">Belum ada booking</p>
            <p class="text-zinc-400 text-sm mt-1">Yuk cari lapangan dan mulai booking!</p>
            <a href="{{ route('user.cari-lapangan') }}"
               class="mt-4 px-5 py-2 bg-zinc-900 text-white text-sm font-medium rounded-lg hover:bg-zinc-700">
                Cari Lapangan
            </a>
        </div>
    @endforelse

    @if($bookings->hasPages())
        <div class="mt-4">{{ $bookings->links() }}</div>
    @endif

</div>
@endsection
