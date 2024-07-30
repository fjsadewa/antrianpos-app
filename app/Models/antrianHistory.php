<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class antrianHistory extends Model{
    use HasFactory;
    protected $table = 'antrian_historys';

    protected $fillable = [
        'id_kategori_layanan',
        'nama_pelayanan',
        'nomor_urut',
        'nama_petugas',
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

    public function employee(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function getNamaPelayananAttribute(){
        return $this->kategoriLayanan->nama_pelayanan ?? null;
    }

    public function getNamaPetugasAttribute(){
        $loket = $this->loketPanggil ?? $this->loketLayani;
        return $loket ? $loket->employee->name : null;
    }
}
