<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'name'      => 'admin',
                'email'     => 'admin@gmail.com',
                'password'  => Hash::make('admin'),
            ],
            [
                'name'      => 'admin',
                'email'     => 'admin@gmail.com',
                'password'  => Hash::make('admin'),
            ]
        );

        User::updateOrCreate(
            [
                'name'      => 'user',
                'email'     => 'user@gmail.com',
                'password'  => Hash::make('user'),
            ],
            [
                'name'      => 'user',
                'email'     => 'user@gmail.com',
                'password'  => Hash::make('user'),
            ]
        );
    }
}
