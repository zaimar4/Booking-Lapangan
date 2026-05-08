<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $fillable = [
        'nama_lapangan',
        'jenis_lapangan',
        'gambar_lapangan',
        'deskripsi_lapangan',
        'harga_sewa',
    ];
    public function booking()
    {
        return $this->hasMany(booking::class);
    }
    public function jenisLapangan()
    {
        return $this->belongsTo(JenisLapangan::class, 'id');
    }
}

