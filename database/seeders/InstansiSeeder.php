<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Instansi;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        // Fakultas
        Instansi::create(['name' => 'Fakultas Teknologi Maju dan Multidisiplin', 'code' => 'FTMM', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Sains Teknologi', 'code' => 'FST', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Farmasi', 'code' => 'FF', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Kesehatan Masyarakat', 'code' => 'FKM', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Kedokteran', 'code' => 'FK', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Kedokteran Gigi', 'code' => 'FKG', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Kedokteran Hewan', 'code' => 'FKH', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Ilmu Bahasa dan Budaya', 'code' => 'FIB', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Ilmu Sosial dan Ilmu Politik', 'code' => 'FISIP', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Ekonomi dan Bisnis', 'code' => 'FEB', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Hukum', 'code' => 'FH', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Vokasi', 'code' => 'FV', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Perikanan dan Kelautan', 'code' => 'FPK', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Keperawatan', 'code' => 'FKP', 'jenis' => 'fakultas']);
        Instansi::create(['name' => 'Fakultas Psikologi', 'code' => 'FP', 'jenis' => 'fakultas']);

        // Perpustakaan
        Instansi::create(['name' => 'Perpustakaan Pusat', 'code' => 'PP', 'jenis' => 'perpustakaan']);
        Instansi::create(['name' => 'Perpustakaan Fakultas Teknologi', 'code' => 'PFT', 'jenis' => 'perpustakaan']);
        Instansi::create(['name' => 'Perpustakaan Fakultas Kedokteran', 'code' => 'PFK', 'jenis' => 'perpustakaan']);
        Instansi::create(['name' => 'Perpustakaan Fakultas Ekonomi', 'code' => 'PFE', 'jenis' => 'perpustakaan']);

        // Lainnya
        Instansi::create(['name' => 'Masjid Kampus', 'code' => 'MK', 'jenis' => 'lainnya']);
        Instansi::create(['name' => 'Kantin Utama', 'code' => 'KU', 'jenis' => 'lainnya']);
        Instansi::create(['name' => 'Parkir Utara', 'code' => 'PU', 'jenis' => 'lainnya']);
        Instansi::create(['name' => 'Parkir Selatan', 'code' => 'PS', 'jenis' => 'lainnya']);
        Instansi::create(['name' => 'Laboratorium Pusat', 'code' => 'LP', 'jenis' => 'lainnya']);
        Instansi::create(['name' => 'Gedung Rektorat', 'code' => 'GR', 'jenis' => 'lainnya']);
        Instansi::create(['name' => 'Aula Utama', 'code' => 'AU', 'jenis' => 'lainnya']);
    }
}