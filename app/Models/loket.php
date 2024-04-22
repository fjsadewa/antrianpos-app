<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loket extends Model
{
    use HasFactory;

    protected $table = 'loket';

    protected $fillable = [
        'nomor_loket',
        'status', 
        'kategori_pelayanan_id', 
        'petugas_id', 
    ];

    public function antrian()
    {
        return $this->hasMany(Antrian::class);
    }

    public function kategoriLayanan()
    {
        return $this->belongsTo(KategoriPelayanan::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
