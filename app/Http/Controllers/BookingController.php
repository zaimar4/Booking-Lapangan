<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $counts = Booking::where('user_id', $userId)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $query = Booking::with(['lapangan.jenisLapangan'])
            ->where('user_id', $userId)
            ->latest();

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('user.bookingsaya', compact('bookings', 'counts'));
    }

    public function create(Lapangan $lapangan)
    {
        return view('user.create', compact('lapangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required',
            'tanggal'     => 'required|date|after_or_equal:today',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ], [
            'tanggal.after_or_equal' => 'Tanggal tidak boleh hari yang sudah lewat',
            'jam_selesai.after'      => 'Jam selesai harus lebih dari jam mulai',
        ]);

        $bentrok = Booking::where('lapangan_id', $request->lapangan_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->exists();

        if ($bentrok) {
            return back()->with('error', 'Jadwal sudah dibooking, pilih waktu lain.');
        }

        Booking::create([
            'user_id'     => Auth::id(),
            'lapangan_id' => $request->lapangan_id,
            'tanggal'     => $request->tanggal,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status'      => 'pending',
        ]);

        return redirect()->route('booking.index')->with('success', 'Booking berhasil! Menunggu konfirmasi admin.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking pending yang bisa dibatalkan.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
} 