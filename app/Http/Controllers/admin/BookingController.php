<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $counts = Booking::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $query = Booking::with(['user', 'lapangan.jenisLapangan'])->latest();

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(15)->withQueryString();

        return view('admin.daftarbooking', compact('bookings', 'counts'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate(['action' => 'required|in:confirmed,completed,cancelled']);

        $action = $request->action;

        $allowed = match($booking->status) {
            'pending'   => ['confirmed', 'cancelled'],
            'confirmed' => ['completed', 'cancelled'],
            default     => [],
        };

        if (!in_array($action, $allowed)) {
            return back()->with('error', 'Aksi tidak valid untuk status booking ini.');
        }

        $booking->update(['status' => $action]);

        $pesan = match($action) {
            'confirmed' => 'Booking berhasil dikonfirmasi.',
            'completed' => 'Booking ditandai selesai.',
            'cancelled' => 'Booking berhasil ditolak.',
        };

        return back()->with('success', $pesan);
    }
}