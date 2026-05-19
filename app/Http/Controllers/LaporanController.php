<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $pendapatan = Booking::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('YEAR(tanggal) as tahun'),
                DB::raw('SUM(total_harga) as total')
            )
            ->where('status', 'confirmed')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->get();

        $bookings = Booking::with('user', 'lapangan')
            ->latest()
            ->get();

        return view('admin.laporan', compact('pendapatan', 'bookings'));
    }

    public function exportPendapatan()
    {
        $pendapatan = Booking::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('YEAR(tanggal) as tahun'),
                DB::raw('SUM(total_harga) as total')
            )
            ->where('status', 'confirmed')
            ->groupBy('tahun', 'bulan')
            ->get();

        $pdf = Pdf::loadView('admin.pdf.pendapatan', compact('pendapatan'));

        return $pdf->download('laporan-pendapatan.pdf');
    }

    public function exportBooking()
    {
        $bookings = Booking::with('user', 'lapangan')->get();

        $pdf = Pdf::loadView('admin.pdf.booking', compact('bookings'));

        return $pdf->download('laporan-booking.pdf');
    }
}