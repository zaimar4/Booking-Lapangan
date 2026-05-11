<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(
        LarapexChart $chart
    ) {

        $bookingData =
            Booking::select(
                DB::raw(
                    'MONTH(created_at) as bulan'
                ),
                DB::raw(
                    'COUNT(*) as total'
                )
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanBooking = [];

        $totalBooking = [];

        foreach (
            $bookingData as $data
        ) {

            $bulanBooking[] =
                date(
                    'F',
                    mktime(
                        0,
                        0,
                        0,
                        $data->bulan,
                        1
                    )
                );

            $totalBooking[] =
                $data->total;

        }

        $bookingChart =
            $chart->barChart()
            ->setTitle(
                'Total Booking Perbulan'
            )
            ->addData(
                $totalBooking
            )
            ->setXAxis(
                $bulanBooking
            );

        $pendapatanData =
            Booking::select(
                DB::raw(
                    'MONTH(created_at) as bulan'
                ),
                DB::raw(
                    'SUM(total_harga) as total'
                )
            )
            ->where(
                'status',
                'approved'
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanPendapatan = [];

        $totalPendapatan = [];

        foreach (
            $pendapatanData as $data
        ) {

            $bulanPendapatan[] =
                date(
                    'F',
                    mktime(
                        0,
                        0,
                        0,
                        $data->bulan,
                        1
                    )
                );

            $totalPendapatan[] =
                $data->total;

        }

        $pendapatanChart =
            $chart->lineChart()
            ->setTitle(
                'Total Pendapatan Perbulan'
            )
            ->addData(
                $totalPendapatan
            )
            ->setXAxis(
                $bulanPendapatan
            );

        $totalBookingSemua =
            Booking::count();

        $bookingPending =
            Booking::where(
                'status',
                'pending'
            )->count();

        $totalPendapatanSemua =
            Booking::where(
                'status',
                'approved'
            )->sum(
                'total_harga'
            );

        $totalLapangan =
            Lapangan::count();

        $bookings =
            Booking::with([
                'user',
                'lapangan.jenisLapangan'
            ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.admindashboard',
            compact(
                'bookingChart',
                'pendapatanChart',
                'totalBookingSemua',
                'bookingPending',
                'totalPendapatanSemua',
                'totalLapangan',
                'bookings'
            )
        );

    }
}