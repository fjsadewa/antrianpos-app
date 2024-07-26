<?php

namespace Database\Seeders;

use App\Models\IP;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IP::updateOrCreate(
            [
                'nomor_ip'      => '1.1.1.1',
            ],
            [
                'nomor_ip'      => '1.1.1.1',
            ]
        );
    }
}
