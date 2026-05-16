@extends('layouts.layout')

@section('title', 'Daftar Booking')

@section('content')

<div class="p-4 sm:p-8">

    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-zinc-900">Daftar Booking</h1>
        <p class="text-zinc-500 text-sm mt-1">Kelola semua booking dari seluruh pengguna</p>
    </div>

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

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-6">
        @php
            $cardData = [
                ['label' => 'Total Booking', 'value' => $counts->sum(), 'color' => 'bg-zinc-100 text-zinc-700'],
                ['label' => 'Pending', 'value' => $counts['pending'] ?? 0, 'color' => 'bg-yellow-50 text-yellow-700'],
                ['label' => 'Dikonfirmasi', 'value' => $counts['confirmed'] ?? 0, 'color' => 'bg-blue-50 text-blue-700'],
                ['label' => 'Selesai', 'value' => $counts['completed'] ?? 0, 'color' => 'bg-green-50 text-green-700'],
            ];
        @endphp
        @foreach($cardData as $card)
            <div class="rounded-xl border border-zinc-200 px-4 sm:px-5 py-3 sm:py-4 {{ $card['color'] }}">
                <p class="text-xs font-medium opacity-70">{{ $card['label'] }}</p>
                <p class="text-xl sm:text-2xl font-bold mt-1">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    @php
        $statuses = [
            'semua' => 'Semua',
            'pending' => 'Pending',
            'confirmed' => 'Dikonfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
        $activeFilter = request('status', 'semua');
    @endphp

    <div class="flex flex-wrap gap-2 mb-4">
        @foreach($statuses as $key => $label)
            <a href="{{ route('admin.daftar-booking', $key !== 'semua' ? ['status' => $key] : []) }}"
               class="px-3 sm:px-4 py-1.5 rounded-full text-xs sm:text-sm font-medium border transition-colors
               {{ $activeFilter === $key
                ? 'bg-zinc-900 text-white border-zinc-900'
                : 'bg-white text-zinc-600 border-zinc-200 hover:border-zinc-400' }}">
                {{ $label }}
                @if($key !== 'semua' && isset($counts[$key]))
                    <span class="ml-1 text-xs {{ $activeFilter === $key ? 'opacity-60' : 'text-zinc-400' }}">
                        ({{ $counts[$key] }})
                    </span>
                @endif
            </a>
        @endforeach
    </div>

    <div class="bg-white border border-zinc-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse text-sm">
                <thead>
                    <tr class="bg-zinc-50 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">
                        <th class="px-4 py-3 border-b border-zinc-200 whitespace-nowrap">#</th>
                        <th class="px-4 py-3 border-b border-zinc-200 whitespace-nowrap">Pemesan</th>
                        <th class="px-4 py-3 border-b border-zinc-200 whitespace-nowrap">Lapangan</th>
                        <th class="px-4 py-3 border-b border-zinc-200 whitespace-nowrap">Tanggal</th>
                        <th class="px-4 py-3 border-b border-zinc-200 whitespace-nowrap">Jam</th>
                        <th class="px-4 py-3 border-b border-zinc-200 whitespace-nowrap">Total Harga</th>
                        <th class="px-4 py-3 border-b border-zinc-200 whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 border-b border-zinc-200 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $i => $booking)
                        @php
                            $durasi = \Carbon\Carbon::parse($booking->jam_mulai)
                                ->diffInHours(\Carbon\Carbon::parse($booking->jam_selesai));
                            $totalHarga = $booking->lapangan->harga_sewa * $durasi;

                            $statusColor = match ($booking->status) {
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'confirmed' => 'bg-blue-100 text-blue-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                default => 'bg-zinc-100 text-zinc-600',
                            };
                            $statusLabel = match ($booking->status) {
                                'pending' => 'Pending',
                                'confirmed' => 'Dikonfirmasi',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                                default => $booking->status,
                            };
                        @endphp
                        <tr class="hover:bg-zinc-50 border-b border-zinc-100 last:border-b-0">

                            <td class="px-4 py-3 text-zinc-400">
                                {{ $bookings->firstItem() + $i }}
                            </td>

                            <td class="px-4 py-3">
                                <p class="font-medium text-zinc-900 whitespace-nowrap">{{ $booking->user->name }}</p>
                                <p class="text-xs text-zinc-400">{{ $booking->user->email }}</p>
                            </td>

                            <td class="px-4 py-3">
                                <p class="font-medium text-zinc-900 whitespace-nowrap">{{ $booking->lapangan->nama_lapangan }}</p>
                                <p class="text-xs text-zinc-400">
                                    {{ $booking->lapangan->jenisLapangan->nama_jenis ?? '-' }}</p>
                            </td>

                            <td class="px-4 py-3 text-zinc-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}
                            </td>

                            <td class="px-4 py-3 text-zinc-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                <span class="text-xs text-zinc-400">({{ $durasi }}j)</span>
                            </td>

                            <td class="px-4 py-3 font-semibold text-green-600 whitespace-nowrap">
                                Rp{{ number_format($totalHarga, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium whitespace-nowrap {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1.5 flex-wrap">

                                    @if($booking->status === 'pending')
                                        <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="action" value="confirmed">
                                            <button class="px-2.5 py-1 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 whitespace-nowrap">
                                                Konfirmasi
                                            </button>
                                        </form>
                                    @endif

                                    @if($booking->status === 'confirmed')
                                        <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="action" value="completed">
                                            <button class="px-2.5 py-1 text-xs font-medium text-green-600 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 whitespace-nowrap">
                                                Selesai
                                            </button>
                                        </form>
                                    @endif

                                    @if(in_array($booking->status, ['pending', 'confirmed']))
                                        <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin tolak booking ini?')">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="action" value="cancelled">
                                            <button class="px-2.5 py-1 text-xs font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 whitespace-nowrap">
                                                Tolak
                                            </button>
                                        </form>
                                    @endif

                                    @if(in_array($booking->status, ['completed', 'cancelled']))
                                        <span class="text-xs text-zinc-300 italic">—</span>
                                    @endif

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-zinc-400">
                                Tidak ada data booking
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($bookings->hasPages())
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    @endif

</div>

@endsection
