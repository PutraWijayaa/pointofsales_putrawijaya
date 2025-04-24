<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => 'Pimpinan',
            'email' => 'pimpinan@example.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => 'Kasir',
            'email' => 'Kasir@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
