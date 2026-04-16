<?php

namespace App\Http\Controllers;

use App\Models\JenisLapangan;
use App\Models\lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query=($user->role === 'admin') ? lapangan::query() : $user->lapangan();
        

        $view =($user->role === 'admin') ? 'admin.admindashboard' : 'user.userdashboard';
        $lapangan = $query->Latest()->paginate(5);
        return view($view, compact( 'lapangan'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenis_lapangan=JenisLapangan::all();
        return view('admin.tambahlapangan',compact('jenis_lapangan'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
   
{
    $request->validate([
        'nama_lapangan' => 'required',
        'jenis_lapangan' => 'required',
        'gambar_lapangan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'harga_sewa' => 'required|numeric|min:0',
    ]);

    $gambar_lapangan = $request->file('gambar_lapangan');
    $nama_gambar = time() . '.' . $gambar_lapangan->extension();
    $gambar_lapangan->move(public_path('images'), $nama_gambar);

    lapangan::create([
        'nama_lapangan' => $request->nama_lapangan,
        'jenis_lapangan' => $request->jenis_lapangan,
        'gambar_lapangan' => $nama_gambar,
        'deskripsi_lapangan' => $request->deskripsi_lapangan,
        'harga_sewa' => $request->harga_sewa,
    ]);
      

    return redirect()->route('admin.dashboard')
        ->with('success', 'Lapangan berhasil ditambahkan.');
}

    /**
     * Display the specified resource.
     */
    public function show(lapangan $lapangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(lapangan $lapangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, lapangan $lapangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(lapangan $lapangan)
    {
        //
    }
}
