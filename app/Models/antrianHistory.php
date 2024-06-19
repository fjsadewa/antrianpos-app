<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class antrianHistory extends Model{
    use HasFactory;
    protected $table = 'antrian_historys';

    protected $fillable = [
        'id_kategori_layanan',
        'nomor_urut',
        'status_antrian',
        'id_loket_panggil',
        'waktu_panggil',
        'id_loket_layani',
        'waktu_selesai_layani',
        'tanggal'
    ];

    public function kategoriLayanan()
    {
        return $this->belongsTo(KategoriPelayanan::class, 'id_kategori_layanan');
    }

    public function loketPanggil()
    {
        return $this->belongsTo(Loket::class, 'id_loket_panggil');
    }

    public function loketLayani()
    {
        return $this->belongsTo(Loket::class, 'id_loket_layani');
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
