<?php

namespace App\Http\Controllers;

use App\Models\JenisLapangan;
use Illuminate\Http\Request;

class JenisLapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisLapangan = JenisLapangan::all();
        return view('admin.jenislapangan', compact('jenisLapangan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tambahjenis_lapangan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required',
        ]);

        JenisLapangan::create([
            'nama_jenis' => $request->nama_jenis,
        ]);

        return redirect()->route('jenis-lapangan')->with('success', 'Jenis lapangan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisLapangan $jenisLapangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisLapangan $jenisLapangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisLapangan $jenisLapangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisLapangan $jenisLapangan)
    {
        $jenisLapangan->delete();
        return redirect()->route('jenis-lapangan')->with('success', 'Jenis lapangan berhasil dihapus.');
    }
}
