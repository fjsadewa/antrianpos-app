<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrian';

    protected $fillable = [
        'nomor_antrian',
        'kategori_pelayanan_id',
        'status',
        'waktu_daftar',
        'waktu_panggilan',
        'waktu_selesai',
        'nomor_loket',
        'user_id',
    ];

    public function kategoriPelayanan()
    {
        return $this->belongsTo(KategoriPelayanan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
