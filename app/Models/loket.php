<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loket extends Model
{
    use HasFactory;

    protected $table = 'lokets';

    protected $fillable = [
        'nomor_loket',
        'status', 
        'kategori_pelayanan_id', 
        'user_id'
    ];

    public function antrian()
    {
        return $this->hasMany(Antrian::class);
    }

    public function kategoriPelayanan()
    {
        return $this->belongsTo(KategoriPelayanan::class,'kategori_pelayanan_id')->withDefault();
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }

}
