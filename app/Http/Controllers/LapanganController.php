<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\JenisLapangan;
use Illuminate\Http\Request;

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
        

        return view('admin.admindashboard', compact('lapangan', 'totalLapangan'));
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
            'gambar_lapangan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga_sewa' => 'required|numeric|min:0',

        ]
        ,
        [
            'harga_sewa.min' => 'Harga Tidak Boleh Minus'
        ]
        );

       
        $gambar = $request->file('gambar_lapangan');
        $nama_gambar = time() . '.' . $gambar->extension();
        $gambar->move(public_path('images'), $nama_gambar);

      
        Lapangan::create([
            'nama_lapangan' => $request->nama_lapangan,
            'jenis_lapangan' => $request->jenis_lapangan,
            'gambar_lapangan' => $nama_gambar,
            'deskripsi_lapangan' => $request->deskripsi_lapangan,
            'harga_sewa' => $request->harga_sewa,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Lapangan berhasil ditambahkan.');
    }

  
    public function getAll()
    {
        $lapangan = Lapangan::with('jenisLapangan')
            ->latest()
            ->paginate(10);

        $jenis_lapangan = JenisLapangan::all();
        $totalLapangan = Lapangan::count();

        return view('admin.adminsemualapangan', compact('lapangan', 'totalLapangan', 'jenis_lapangan'));
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

        if ($request->hasFile('gambar_lapangan')) {

            if ($lapangan->gambar_lapangan && file_exists(public_path('images/' . $lapangan->gambar_lapangan))) {
                unlink(public_path('images/' . $lapangan->gambar_lapangan));
            }

            $gambar = $request->file('gambar_lapangan');
            $nama_gambar = time() . '.' . $gambar->extension();
            $gambar->move(public_path('images'), $nama_gambar);

            $lapangan->gambar_lapangan = $nama_gambar;
        }

       $lapangan->update($request->only([
            'nama_lapangan',
            'jenis_lapangan_id',
            'deskripsi_lapangan',
            'harga_sewa'
        ]));
        return redirect()->route('admin.semua-lapangan')
            ->with('success', 'Lapangan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lapangan $lapangan)
    {
        if ($lapangan->gambar_lapangan && file_exists(public_path('images/' . $lapangan->gambar_lapangan))) {
            unlink(public_path('images/' . $lapangan->gambar_lapangan));
        }

        $lapangan->delete();

        return redirect()->back()
            ->with('success', 'Lapangan berhasil dihapus.');
    }

    public function show(lapangan $lapangan)
    {
        $lapangan->load('jenisLapangan');
        return view('admin.detaillapangan', compact('lapangan'));
    }
}