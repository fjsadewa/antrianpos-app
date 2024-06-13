<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisplaySet extends Model
{
    use HasFactory;
    protected $table = 'display_set';

    protected $fillable = [
        'status'
    ];
}
