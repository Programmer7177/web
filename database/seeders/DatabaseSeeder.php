<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            InstansiTypeSeeder::class,
            InstansiSeeder::class,
            UserSeeder::class, // Ini membuat user mahasiswa dummy
            AdminUserSeeder::class, // TAMBAHKAN PEMANGGILAN INI
            CategorySeeder::class,
        ]);
    }
}