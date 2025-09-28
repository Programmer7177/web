<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin_sarpras',
            'email' => 'admin@admin.com', // Email khusus admin
            'password' => Hash::make('password_admin'), // Ganti dengan password yang aman
            'role_id' => 2, // Asumsi 'admin_sarpras' memiliki role_id = 2
            'instansi_id' => 1, // Asumsi admin berada di instansi pusat
        ]);
    }
}