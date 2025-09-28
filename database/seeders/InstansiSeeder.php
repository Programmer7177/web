<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Instansi;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        Instansi::create(['name' => 'Fakultas Teknologi Maju dan Multidisiplin', 'code' => 'FTMM']);
        Instansi::create(['name' => 'Fakultas Sains Teknologi', 'code' => 'FST']);
        Instansi::create(['name' => 'Fakultas Farmasi', 'code' => 'FF']);
        Instansi::create(['name' => 'Fakultas Kesehatan Masyarakat', 'code' => 'FKM']);
        Instansi::create(['name' => 'Fakultas Kedokteran', 'code' => 'FK']);
        Instansi::create(['name' => 'Fakultas Kedokteran Gigi', 'code' => 'FKG']);
        Instansi::create(['name' => 'Fakultas Kedokteran Hewan', 'code' => 'FKH']);
        Instansi::create(['name' => 'Fakultas Ilmu Bahasa dan Budaya', 'code' => 'FIB']);
        Instansi::create(['name' => 'Fakultas Ilmu Sosial dan Ilmu Politik', 'code' => 'FISIP']);
        Instansi::create(['name' => 'Fakultas Ekonomi dan Bisnis', 'code' => 'FEB']);
        Instansi::create(['name' => 'Fakultas Hukum', 'code' => 'FH']);
        Instansi::create(['name' => 'Fakultas Vokasi', 'code' => 'FV']);
        Instansi::create(['name' => 'Fakultas Perikanan dan Kelautan', 'code' => 'FPK']);
        Instansi::create(['name' => 'Fakultas Keperawatan', 'code' => 'FKP']);
        Instansi::create(['name' => 'Fakultas Psikologi', 'code' => 'FP']);
        Instansi::create(['name' => 'Perpustakaan A', 'code' => 'PA']);
        Instansi::create(['name' => 'Perpustakaan B', 'code' => 'PB']);
        Instansi::create(['name' => 'Perpustakaan C', 'code' => 'PC']);
        Instansi::create(['name' => 'Masjid A', 'code' => 'MA']);
        Instansi::create(['name' => 'Masjid B', 'code' => 'MB']);
        Instansi::create(['name' => 'Masjid C', 'code' => 'MC']);
    }
}