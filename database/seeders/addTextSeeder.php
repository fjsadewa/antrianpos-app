<?php

namespace Database\Seeders;

use App\Models\addText;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class addTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        addText::updateOrCreate(
            [
                'text'      => 'Terima kasih telah berkunjung ke Kantor POS Malang',
            ],
            [
                'text'      => 'Terima kasih telah berkunjung ke Kantor POS Malang',
            ]
        );
    }
}
