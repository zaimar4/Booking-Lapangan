@extends('layouts.layout')

@section('title', 'Laporan Pendapatan')

@section('content')
<div class="p-4 sm:p-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Laporan Pendapatan</h1>
            <p class="text-gray-500 mt-1 text-sm">Rekap pendapatan dari booking lapangan</p>
        </div>
        {{-- Export PDF Button --}}
        <a href="{{ route('admin.laporan.pdf', request()->query()) }}"
           target="_blank"
           class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm shadow-sm">
            <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" overflow="visible">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
            <span>Export PDF</span>
        </a>
    </div>

    {{-- Filter Form --}}
    <div class="bg-white rounded-2xl border shadow-sm p-5 mb-6">
        <form method="GET" action="{{ route('admin.laporan.pendapatan') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ request('dari') }}"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Sampai Tanggal</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-lg px-3 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">                    <option value="">Semua Status</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Lapangan</label>
                <select name="lapangan_id" class="w-full border border-gray-200 rounded-lg px-3 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">                    <option value="">Semua Lapangan</option>
                    @foreach($lapangans as $lp)
                        <option value="{{ $lp->id }}" {{ request('lapangan_id') == $lp->id ? 'selected' : '' }}>
                            {{ $lp->nama_lapangan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-zinc-900 hover:bg-zinc-700 text-white font-semibold px-5 py-2 rounded-lg text-sm transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.laporan.pendapatan') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg text-sm transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 mb-6">
        <div class="bg-white rounded-2xl border shadow-sm p-4 sm:p-5">
            <p class="text-gray-500 text-xs sm:text-sm font-medium">Total Pendapatan</p>
            <h2 class="text-lg sm:text-2xl font-bold text-green-600 mt-2">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </h2>
        </div>
        <div class="bg-white rounded-2xl border shadow-sm p-4 sm:p-5">
            <p class="text-gray-500 text-xs sm:text-sm font-medium">Total Transaksi</p>
            <h2 class="text-lg sm:text-2xl font-bold text-blue-600 mt-2">{{ $totalTransaksi }}</h2>
        </div>
        <div class="bg-white rounded-2xl border shadow-sm p-4 sm:p-5">
            <p class="text-gray-500 text-xs sm:text-sm font-medium">Rata-rata / Transaksi</p>
            <h2 class="text-lg sm:text-2xl font-bold text-purple-600 mt-2">
                Rp {{ $totalTransaksi > 0 ? number_format($totalPendapatan / $totalTransaksi, 0, ',', '.') : '0' }}
            </h2>
        </div>
        <div class="bg-white rounded-2xl border shadow-sm p-4 sm:p-5">
            <p class="text-gray-500 text-xs sm:text-sm font-medium">Total Jam Terisi</p>
            <h2 class="text-lg sm:text-2xl font-bold text-orange-500 mt-2">{{ $totalJam }} Jam</h2>
        </div>
    </div>

    {{-- Pendapatan per Lapangan --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

        {{-- Chart Pendapatan per Lapangan --}}
        <div class="bg-white rounded-2xl border shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Pendapatan per Lapangan</h3>
            <div id="chart-lapangan"></div>
        </div>

        {{-- Pendapatan per Bulan --}}
        <div class="bg-white rounded-2xl border shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Tren Pendapatan Bulanan</h3>
            <div id="chart-bulanan"></div>
        </div>

    </div>

    {{-- Tabel Detail Transaksi --}}
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden border">
        <div class="p-4 sm:p-5 border-b flex items-center justify-between">
            <h2 class="text-base sm:text-lg font-semibold text-gray-700">Detail Transaksi</h2>
            <span class="text-xs text-gray-400">{{ $bookings->total() }} transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-600 border-b">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap font-semibold">No</th>
                        <th class="px-4 py-3 whitespace-nowrap font-semibold">Tanggal</th>
                        <th class="px-4 py-3 whitespace-nowrap font-semibold">Pemesan</th>
                        <th class="px-4 py-3 whitespace-nowrap font-semibold">Lapangan</th>
                        <th class="px-4 py-3 whitespace-nowrap font-semibold">Jam</th>
                        <th class="px-4 py-3 whitespace-nowrap font-semibold">Durasi</th>
                        <th class="px-4 py-3 whitespace-nowrap font-semibold">Status</th>
                        <th class="px-4 py-3 whitespace-nowrap font-semibold">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($bookings as $i => $item)
                    @php
                        $durasi = \Carbon\Carbon::parse($item->jam_mulai)->diffInHours(\Carbon\Carbon::parse($item->jam_selesai));
                        $pendapatan = $item->lapangan->harga_sewa * $durasi;
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $bookings->firstItem() + $i }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-600">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 font-medium whitespace-nowrap">
                            {{ $item->user->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-medium">{{ $item->lapangan->nama_lapangan }}</div>
                            <div class="text-xs text-gray-400">{{ $item->lapangan->jenisLapangan->nama_jenis ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap text-xs">
                            {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} –
                            {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                        </td>
                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ $durasi }} jam</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($item->status == 'confirmed')
                                <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">Dikonfirmasi</span>
                            @elseif($item->status == 'completed')
                                <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">Selesai</span>
                            @elseif($item->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-2.5 py-1 rounded-full font-medium">Pending</span>
                            @else
                                <span class="bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full font-medium">Dibatalkan</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold text-green-600 whitespace-nowrap">
                            Rp {{ number_format($pendapatan, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-12 text-gray-400">
                            <div class="text-3xl mb-2">📭</div>
                            <div>Tidak ada data transaksi</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($bookings->count() > 0)
                <tfoot class="bg-gray-50 border-t">
                    <tr>
                        <td colspan="7" class="px-4 py-3 font-bold text-right text-gray-700">Total Pendapatan</td>
                        <td class="px-4 py-3 font-bold text-green-600 text-base">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="p-4 border-t">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Data dari PHP
    const lapanganLabels = @json($chartLapangan->pluck('nama'));
    const lapanganValues = @json($chartLapangan->pluck('total'));

    const bulanLabels = @json($chartBulanan->pluck('bulan_label'));
    const bulanValues = @json($chartBulanan->pluck('total'));

    // Chart Pendapatan per Lapangan
    const optLapangan = {
        series: [{ name: 'Pendapatan', data: lapanganValues }],
        chart: { type: 'bar', height: 250, toolbar: { show: false } },
        colors: ['#16a34a'],
        plotOptions: { bar: { borderRadius: 6, distributed: true } },
        dataLabels: { enabled: false },
        xaxis: { categories: lapanganLabels, labels: { style: { fontSize: '11px' } } },
        yaxis: {
            labels: {
                formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v)
            }
        },
        tooltip: {
            y: { formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) }
        },
        legend: { show: false },
        grid: { borderColor: '#f3f4f6' }
    };
    new ApexCharts(document.getElementById('chart-lapangan'), optLapangan).render();

    // Chart Tren Bulanan
    const optBulanan = {
        series: [{ name: 'Pendapatan', data: bulanValues }],
        chart: { type: 'area', height: 250, toolbar: { show: false } },
        colors: ['#16a34a'],
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: { categories: bulanLabels, labels: { style: { fontSize: '11px' } } },
        yaxis: {
            labels: {
                formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v)
            }
        },
        tooltip: {
            y: { formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) }
        },
        grid: { borderColor: '#f3f4f6' }
    };
    new ApexCharts(document.getElementById('chart-bulanan'), optBulanan).render();
</script>
@endsection