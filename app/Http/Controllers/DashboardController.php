<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(LarapexChart $chart)
    {
        // ── Grafik Total Booking Perbulan ──────────────────────────────────────
        $bookingData = Booking::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanBooking = [];
        $jumlahBooking = [];
        foreach ($bookingData as $data) {
            $bulanBooking[] = date('F', mktime(0, 0, 0, $data->bulan, 1));
            $jumlahBooking[] = $data->total;
        }

        $bookingChart = $chart->barChart()
            ->setTitle('Total Booking Perbulan')
            ->addData($jumlahBooking)
            ->setXAxis($bulanBooking);

        $pendapatanData = Booking::select(
            DB::raw('MONTH(bookings.created_at) as bulan'),
            DB::raw('SUM(
                    lapangans.harga_sewa *
                    TIMESTAMPDIFF(HOUR, bookings.jam_mulai, bookings.jam_selesai)
                ) as total')
        )
            ->join('lapangans', 'lapangans.id', '=', 'bookings.lapangan_id')
            ->whereIn('bookings.status', ['confirmed', 'completed'])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanPendapatan = [];
        $nilaiPendapatan = [];
        foreach ($pendapatanData as $data) {
            $bulanPendapatan[] = date('F', mktime(0, 0, 0, $data->bulan, 1));
            $nilaiPendapatan[] = $data->total;
        }

        $pendapatanChart = $chart->barChart()
            ->setTitle('Total Pendapatan Perbulan')
            ->addData($nilaiPendapatan)
            ->setXAxis($bulanPendapatan);

        // ── Summary Cards ──────────────────────────────────────────────────────
        $totalBookingSemua = Booking::count();
        $bookingPending = Booking::where('status', 'pending')->count();
        $totalLapangan = Lapangan::count();

        // Total pendapatan = harga_sewa * durasi untuk booking confirmed/completed
        $totalPendapatanSemua = Booking::join('lapangans', 'lapangans.id', '=', 'bookings.lapangan_id')
            ->whereIn('bookings.status', ['confirmed', 'completed'])
            ->selectRaw('SUM(lapangans.harga_sewa * TIMESTAMPDIFF(HOUR, bookings.jam_mulai, bookings.jam_selesai)) as total')
            ->value('total') ?? 0;

        $bookings = Booking::with(['user', 'lapangan.jenisLapangan'])
            ->latest()
            ->paginate(10);

        return view('admin.admindashboard', compact(
            'bookingChart',
            'pendapatanChart',
            'totalBookingSemua',
            'bookingPending',
            'totalPendapatanSemua',
            'totalLapangan',
            'bookings'
        ));
    }
}