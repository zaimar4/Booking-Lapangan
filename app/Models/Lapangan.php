<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama_lapangan',
        'jenis_lapangan',
        'gambar_lapangan',
        'deskripsi_lapangan',
        'harga_sewa',
        'jam_buka',
        'jam_tutup'
    ];
    public function booking()
    {
        return $this->hasMany(booking::class);
    }
    public function jenisLapangan()
    {
        return $this->belongsTo(JenisLapangan::class,'jenis_lapangan' ,'id');
    }
}

