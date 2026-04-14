<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisLapangan extends Model
{
    protected $fillable = [
        'nama_jenis',
    ];

    public function lapangan()
    {
        return $this->hasMany(lapangan::class);
    }
}
