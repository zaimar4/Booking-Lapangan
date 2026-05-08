<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'lapangan_id',
        'user_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'total_harga',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
}