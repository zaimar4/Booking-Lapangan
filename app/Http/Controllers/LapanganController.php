<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\JenisLapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class LapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Lapangan::with('jenisLapangan');

        $totalLapangan = $query->count();
        $lapangan = $query->latest()->paginate(5);
        
        $view = Auth::user()->role == 'admin' ? 'admin.admindashboard' : 'user.userdashboard';
        $bookingpending = Booking::where('status', 'pending')->count();
        $bookingapproved = Booking::where('status', 'approved')->count();
        $totalbooking = Booking::count();
        $bookings = Booking::with(['lapangan.jenisLapangan'])->latest()->paginate(10);

        return view($view, compact('lapangan', 'totalLapangan', 'bookingpending', 'bookingapproved', 'totalbooking', 'bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenis_lapangan = JenisLapangan::all();

        return view('admin.tambahlapangan', compact('jenis_lapangan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required',
            'jenis_lapangan' => 'required',
            'gambar_lapangan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jam_buka' => 'required',
            'jam_tutup'=> 'required|after:jam_buka',
            'harga_sewa' => 'required|numeric|min:0',
        ], [
            'harga_sewa.min' => 'Harga Tidak Boleh Minus'
        ]);

        $imageUrl = null;
        
        if ($request->hasFile('gambar_lapangan')) {
            $file = $request->file('gambar_lapangan');
            $imageUrl = $this->uploadToSupabase($file);
        }
        
        Lapangan::create([
            'nama_lapangan' => $request->nama_lapangan,
            'jenis_lapangan' => $request->jenis_lapangan,
            'gambar_lapangan' => $imageUrl,
            'deskripsi_lapangan' => $request->deskripsi_lapangan,
            'harga_sewa' => $request->harga_sewa,
            'jam_buka' => $request->jam_buka,
            'jam_tutup'=> $request->jam_tutup
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function getAll(Request $request)
    {
        $query = \App\Models\Lapangan::with('jenisLapangan')->latest();
 
        if ($request->filled('search')) {
            $query->where('nama_lapangan', 'like', '%' . $request->search . '%');
        }
 
        if ($request->filled('jenis')) {
            $query->where('jenis_lapangan', $request->jenis);
        }
 
        $jenis_lapangan = JenisLapangan::all();
        $totalLapangan  = Lapangan::count();
       
 
        if (Auth::user()->role === 'admin') {
            $lapangan = $query->paginate(10)->withQueryString();
            return view('admin.adminsemualapangan', compact('lapangan', 'totalLapangan', 'jenis_lapangan'));
        }
 
        $lapangan = $query->paginate(9)->withQueryString();
        return view('user.temukanlapangan', compact('lapangan', 'jenis_lapangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lapangan $lapangan)
    {
        $jenis_lapangan = JenisLapangan::all();

        return view('admin.editlapangan', compact('lapangan', 'jenis_lapangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lapangan $lapangan)
    {
        $request->validate([
            'nama_lapangan' => 'sometimes|required',
            'jenis_lapangan' => 'sometimes|required',
            'harga_sewa' => 'sometimes|required|numeric|min:0',
            'gambar_lapangan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $dataUpdate = $request->only([
            'nama_lapangan',
            'jenis_lapangan',
            'deskripsi_lapangan',
            'harga_sewa'
        ]);

        if ($request->hasFile('gambar_lapangan')) {
            if ($lapangan->gambar_lapangan) {
                $this->deleteFromSupabase($lapangan->gambar_lapangan);
            }

            $file = $request->file('gambar_lapangan');
            $dataUpdate['gambar_lapangan'] = $this->uploadToSupabase($file);
        }

        $lapangan->update($dataUpdate);

        return redirect()->route('admin.semua-lapangan')
            ->with('success', 'Lapangan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lapangan $lapangan)
    {
        if ($lapangan->gambar_lapangan) {
            $this->deleteFromSupabase($lapangan->gambar_lapangan);
        }

        $lapangan->delete();

        return redirect()->back()
            ->with('success', 'Lapangan berhasil dihapus.');
    }

    public function show(lapangan $lapangan)
    {
        $view = Auth::user()->role == 'admin' ? 'admin.detaillapangan' : 'user.userdetaillapangan';
        $lapangan->load('jenisLapangan');
        $totalPendapatan = Booking::where('status', 'selesai')
    ->sum('total_harga');
        return view($view, compact('lapangan','totalPendapatan'));
    }

    private function uploadToSupabase($file)
    {
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $fileContent = file_get_contents($file->getRealPath());

        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_API_KEY');
        $bucket = env('SUPABASE_BUCKET');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $supabaseKey,
            'apiKey' => $supabaseKey,
        ])->attach(
            'file',
            $fileContent,
            $fileName
        )->post(
            $supabaseUrl . '/storage/v1/object/' . $bucket . '/' . $fileName
        );

        if ($response->successful()) {
            return "{$supabaseUrl}/storage/v1/object/public/{$bucket}/{$fileName}";
        }

        throw new \Exception('Upload ke Supabase gagal: ' . $response->body());
    }

    private function deleteFromSupabase($url)
    {
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_API_KEY');
        $bucket = env('SUPABASE_BUCKET');

        $baseUrl = "{$supabaseUrl}/storage/v1/object/public/{$bucket}/";
        $fileName = str_replace($baseUrl, '', $url);

        if ($fileName && $fileName !== $url) {
            Http::withHeaders([
                'Authorization' => 'Bearer ' . $supabaseKey,
                'apiKey' => $supabaseKey,
            ])->delete($supabaseUrl . '/storage/v1/object/' . $bucket . '/' . $fileName);
        }
    }
}