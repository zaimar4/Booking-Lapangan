<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman laporan pendapatan dengan filter.
     */
    public function index(Request $request)
    {
        $query = $this->buildQuery($request);

        // Paginated untuk tabel
        $bookings = (clone $query)->with(['user', 'lapangan.jenisLapangan'])
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        // All (tanpa paginate) untuk summary & charts
        $allForSummary = (clone $query)->with('lapangan')->get();

        $totalPendapatan = $allForSummary->sum(function ($b) {
            $durasi = Carbon::parse($b->jam_mulai)->diffInHours(Carbon::parse($b->jam_selesai));
            return $b->lapangan->harga_sewa * $durasi;
        });

        $totalTransaksi = $allForSummary->count();

        $totalJam = $allForSummary->sum(function ($b) {
            return Carbon::parse($b->jam_mulai)->diffInHours(Carbon::parse($b->jam_selesai));
        });

        // Chart: pendapatan per lapangan
        $chartLapangan = $allForSummary->groupBy('lapangan_id')->map(function ($group) {
            $total = $group->sum(function ($b) {
                $d = Carbon::parse($b->jam_mulai)->diffInHours(Carbon::parse($b->jam_selesai));
                return $b->lapangan->harga_sewa * $d;
            });
            return [
                'nama'  => $group->first()->lapangan->nama_lapangan,
                'total' => $total,
            ];
        })->values();

        // Chart: pendapatan per bulan (dari seluruh data yang difilter)
        $chartBulanan = $allForSummary->groupBy(fn ($b) => Carbon::parse($b->tanggal)->format('Y-m'))
            ->map(function ($group, $key) {
                $total = $group->sum(function ($b) {
                    $d = Carbon::parse($b->jam_mulai)->diffInHours(Carbon::parse($b->jam_selesai));
                    return $b->lapangan->harga_sewa * $d;
                });
                return [
                    'bulan_label' => Carbon::createFromFormat('Y-m', $key)->translatedFormat('M Y'),
                    'total'       => $total,
                ];
            })->sortKeys()->values();

        $lapangans = Lapangan::orderBy('nama_lapangan')->get();

        return view('admin.laporanpendapatan', compact(
            'bookings',
            'totalPendapatan',
            'totalTransaksi',
            'totalJam',
            'chartLapangan',
            'chartBulanan',
            'lapangans'
        ));
    }

    /**
     * Export laporan ke PDF (DomPDF).
     */
    public function exportPdf(Request $request)
    {
        $query = $this->buildQuery($request);

        $allBookings = (clone $query)->with(['user', 'lapangan.jenisLapangan'])
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalPendapatan = $allBookings->sum(function ($b) {
            $d = Carbon::parse($b->jam_mulai)->diffInHours(Carbon::parse($b->jam_selesai));
            return $b->lapangan->harga_sewa * $d;
        });

        $totalTransaksiAll = $allBookings->count();

        $totalJam = $allBookings->sum(function ($b) {
            return Carbon::parse($b->jam_mulai)->diffInHours(Carbon::parse($b->jam_selesai));
        });

        $lapangans = Lapangan::orderBy('nama_lapangan')->get();

        $pdf = Pdf::loadView('admin.laporanpendapatan_pdf', compact(
            'allBookings',
            'totalPendapatan',
            'totalTransaksiAll',
            'totalJam',
            'lapangans'
        ))->setPaper('a4', 'landscape');

        $filename = 'Laporan-Pendapatan-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Build query berdasarkan filter request.
     */
    private function buildQuery(Request $request)
    {
        $query = Booking::query()
            ->whereIn('status', ['confirmed', 'completed']); // hanya yang menghasilkan pendapatan

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('lapangan_id')) {
            $query->where('lapangan_id', $request->lapangan_id);
        }

        return $query;
    }
}