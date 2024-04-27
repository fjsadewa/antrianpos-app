<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPelayanan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pelayanans';

    protected $fillable =[
        'kode_pelayanan',
        'nama_pelayanan',
        'deskripsi',
        'image',
    ];

    public function antrian()
    {
        return $this->hasMany(Antrian::class);
    }
    
    public function loket()
    {
        return $this->hasMany(Loket::class);
    }
}
