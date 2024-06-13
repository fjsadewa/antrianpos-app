<?php

namespace Database\Seeders;

use App\Models\DisplaySet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisplaySetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DisplaySet::updateOrCreate(
            [
                'status'      => 'youtube',
            ],
            [
                'status'      => 'youtube',
            ]
        );
    }
}
