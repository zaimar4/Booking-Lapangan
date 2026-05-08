<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create()
    {
        $lapangan = Lapangan::all();

        return view('booking.create', compact('lapangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required',
            'tanggal' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $bentrok = Booking::where('lapangan_id', $request->lapangan_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($query) use ($request) {

                $query->whereBetween('jam_mulai', [
                    $request->jam_mulai,
                    $request->jam_selesai
                ])

                ->orWhereBetween('jam_selesai', [
                    $request->jam_mulai,
                    $request->jam_selesai
                ])

                ->orWhere(function ($q) use ($request) {
                    $q->where('jam_mulai', '<=', $request->jam_mulai)
                      ->where('jam_selesai', '>=', $request->jam_selesai);
                });

            })
            ->exists();

        if ($bentrok) {
            return back()->with('error', 'Jadwal sudah dibooking');
        }

        Booking::create([
            'user_id' => auth()->id(),
            'lapangan_id' => $request->lapangan_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Booking berhasil');
    }
}