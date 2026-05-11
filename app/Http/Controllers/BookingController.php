<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

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
    public function getnewbooking(){
        $query = Booking::with(['lapangan.jenisLapangan'])
            ->where('status', 'pending')
            ->latest()->paginate(10);
            
        return view('admin.admindashboard', compact('query'));
    }
    

   public function create(Lapangan $lapangan)
{
    $bookings = Booking::where('lapangan_id', $lapangan->id)
        ->where('tanggal', today())
        ->get();

    $bookedSlots = [];

    foreach ($bookings as $booking) {

        $mulai = (int) explode(':', $booking->jam_mulai)[0];

        $selesai = (int) explode(':', $booking->jam_selesai)[0];

        for ($i = $mulai; $i < $selesai; $i++) {

            $bookedSlots[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';

        }

    }

    return view(
        'user.create',
        compact('lapangan', 'bookedSlots')
    );
}

  public function store(Request $request)
{
    $request->validate([
        'lapangan_id' => 'required',
        'tanggal'     => 'required|date|after_or_equal:today',
        'slots'       => 'required|array|min:1',
    ], [
        'tanggal.required'       => 'Tanggal wajib dipilih',
        'tanggal.after_or_equal' => 'Tanggal tidak boleh hari yang sudah lewat',
        'slots.required'         => 'Pilih minimal satu slot booking',
    ]);

    $slots = $request->slots;

    sort($slots);


    for ($i = 0; $i < count($slots) - 1; $i++) {

        $current =
            (int) explode(':', $slots[$i])[0];

        $next =
            (int) explode(':', $slots[$i + 1])[0];

        if ($next !== $current + 1) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Slot harus berurutan'
                );

        }

    }


    $jamMulai = $slots[0];

    $jamTerakhir =
        (int) explode(':', end($slots))[0];

    $jamSelesai =
        str_pad(
            $jamTerakhir + 1,
            2,
            '0',
            STR_PAD_LEFT
        ) . ':00';

   

    $bentrok = Booking::where(
            'lapangan_id',
            $request->lapangan_id
        )
        ->where(
            'tanggal',
            $request->tanggal
        )
        ->where(function ($query)
            use ($jamMulai, $jamSelesai) {

            $query->where(
                    'jam_mulai',
                    '<',
                    $jamSelesai
                )
                ->where(
                    'jam_selesai',
                    '>',
                    $jamMulai
                );

        })
        ->exists();

    if ($bentrok) {

        return back()
            ->withInput()
            ->with(
                'error',
                'Jadwal sudah dibooking'
            );

    }

    Booking::create([

        'user_id'     => Auth::id(),

        'lapangan_id' => $request->lapangan_id,

        'tanggal'     => $request->tanggal,

        'jam_mulai'   => $jamMulai,

        'jam_selesai' => $jamSelesai,

        'status'      => 'pending',

    ]);

    return redirect()
        ->route('booking.index')
        ->with(
            'success',
            'Booking berhasil dibuat'
        );
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