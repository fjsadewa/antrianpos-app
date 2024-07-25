<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cabang::updateOrCreate(
            [
                'text'      => 'KCU MALANG',
            ],
            [
                'text'      => 'KCU MALANG',
            ]
        );
    }
}
