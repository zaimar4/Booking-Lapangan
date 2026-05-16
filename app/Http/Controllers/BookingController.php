<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function getBookedSlots($lapanganId, $tanggal)
    {
        $bookings = Booking::where('lapangan_id', $lapanganId)
            ->where('tanggal', $tanggal)
            ->whereIn('status', ['pending', 'approved'])
            ->get();

        $bookedSlots = [];

        foreach ($bookings as $booking) {
            $mulai = (int) explode(':', $booking->jam_mulai)[0];
            $selesai = (int) explode(':', $booking->jam_selesai)[0];

            for ($i = $mulai; $i < $selesai; $i++) {
                $bookedSlots[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
            }
        }

        return response()->json($bookedSlots);
    }

    public function create(Lapangan $lapangan)
    {
        $bookings = Booking::where('lapangan_id', $lapangan->id)
            ->where('tanggal', today())
            ->whereIn('status', ['pending', 'approved'])
            ->get();

        $bookedSlots = [];

        foreach ($bookings as $booking) {
            $mulai = (int) explode(':', $booking->jam_mulai)[0];
            $selesai = (int) explode(':', $booking->jam_selesai)[0];

            for ($i = $mulai; $i < $selesai; $i++) {
                $bookedSlots[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
            }
        }

        $jamBuka = (int) explode(':', $lapangan->jam_buka)[0];
        $jamTutup = (int) explode(':', $lapangan->jam_tutup)[0];

        $availableSlots = [];

        for ($i = $jamBuka; $i < $jamTutup; $i++) {
            $availableSlots[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
        }

        return view('user.create', compact(
            'lapangan',
            'bookedSlots',
            'availableSlots'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'slots' => 'required|array|min:1',
        ], [
            'tanggal.required' => 'Tanggal wajib dipilih',
            'tanggal.after_or_equal' => 'Tanggal tidak boleh hari yang sudah lewat',
            'slots.required' => 'Pilih minimal satu slot booking',
        ]);

        $slots = $request->slots;

        sort($slots);

        for ($i = 0; $i < count($slots) - 1; $i++) {
            $current = (int) explode(':', $slots[$i])[0];
            $next = (int) explode(':', $slots[$i + 1])[0];

            if ($next !== $current + 1) {
                return back()->withInput()->with('error', 'Slot harus berurutan');
            }
        }

        if ($request->tanggal == now()->toDateString()) {
            $nowHour = (int) now()->format('H');

            foreach ($slots as $slot) {
                $slotHour = (int) explode(':', $slot)[0];

                if ($slotHour <= $nowHour) {
                    return back()->withInput()->with('error', 'Tidak bisa booking jam yang sudah lewat');
                }
            }
        }

        $jamMulai = $slots[0];

        $jamTerakhir = (int) explode(':', end($slots))[0];

        $jamSelesai = str_pad($jamTerakhir + 1, 2, '0', STR_PAD_LEFT) . ':00';

        $lapangan = Lapangan::findOrFail($request->lapangan_id);

        $jamBuka = $lapangan->jam_buka;
        $jamTutup = $lapangan->jam_tutup;

        if ($jamMulai < $jamBuka || $jamSelesai > $jamTutup) {
            return back()->withInput()->with('error', 'Booking di luar jam operasional');
        }

        DB::beginTransaction();

        try {
            $bentrok = Booking::where('lapangan_id', $request->lapangan_id)
                ->where('tanggal', $request->tanggal)
                ->whereIn('status', ['pending', 'approved'])
                ->where(function ($query) use ($jamMulai, $jamSelesai) {
                    $query->where('jam_mulai', '<', $jamSelesai)
                        ->where('jam_selesai', '>', $jamMulai);
                })
                ->lockForUpdate()
                ->exists();

            if ($bentrok) {
                DB::rollBack();

                return back()->withInput()->with('error', 'Jadwal sudah dibooking');
            }

            $durasi = count($slots);
            $totalHarga = $durasi * $lapangan->harga_sewa;

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'lapangan_id' => $request->lapangan_id,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'status' => 'pending',
                'total_harga' => $totalHarga,
            ]);

            DB::commit();

            $pesan = "Halo saya mau melakukan pembayaran\n\n";
            $pesan .= "Nama Lapangan : " . $lapangan->nama_lapangan . "\n";
            $pesan .= "Nama : " . Auth::user()->name . "\n";
            $pesan .= "Harga : Rp" . number_format($booking->total_harga, 0, ',', '.') . "\n";
            $pesan .= "Tanggal : " . $booking->tanggal . "\n";
            $pesan .= "Jam : " . $booking->jam_mulai . " - " . $booking->jam_selesai;

            $url = "https://wa.me/+6283851072814?text=" . urlencode($pesan);

            return redirect($url);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Terjadi kesalahan saat booking');
        }
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking pending yang bisa dibatalkan');
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Booking berhasil dibatalkan');
    }

    public function myBooking()
    {
        $bookings = Booking::with(['lapangan.jenisLapangan'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.booking-saya', compact('bookings'));
    }
}