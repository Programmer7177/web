<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Instansi;
use App\Models\InstansiType;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        // Get instansi types
        $fakultasType = InstansiType::where('name', 'Fakultas')->first();
        $perpustakaanType = InstansiType::where('name', 'Perpustakaan')->first();
        $masjidType = InstansiType::where('name', 'Masjid')->first();

        // Fakultas
        Instansi::create(['name' => 'Fakultas Teknologi Maju dan Multidisiplin', 'code' => 'FTMM', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Sains Teknologi', 'code' => 'FST', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Farmasi', 'code' => 'FF', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Kesehatan Masyarakat', 'code' => 'FKM', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Kedokteran', 'code' => 'FK', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Kedokteran Gigi', 'code' => 'FKG', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Kedokteran Hewan', 'code' => 'FKH', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Ilmu Bahasa dan Budaya', 'code' => 'FIB', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Ilmu Sosial dan Ilmu Politik', 'code' => 'FISIP', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Ekonomi dan Bisnis', 'code' => 'FEB', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Hukum', 'code' => 'FH', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Vokasi', 'code' => 'FV', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Perikanan dan Kelautan', 'code' => 'FPK', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Keperawatan', 'code' => 'FKP', 'instansi_type_id' => $fakultasType->instansi_type_id]);
        Instansi::create(['name' => 'Fakultas Psikologi', 'code' => 'FP', 'instansi_type_id' => $fakultasType->instansi_type_id]);

        // Perpustakaan
        Instansi::create(['name' => 'Perpustakaan A', 'code' => 'PA', 'instansi_type_id' => $perpustakaanType->instansi_type_id]);
        Instansi::create(['name' => 'Perpustakaan B', 'code' => 'PB', 'instansi_type_id' => $perpustakaanType->instansi_type_id]);
        Instansi::create(['name' => 'Perpustakaan C', 'code' => 'PC', 'instansi_type_id' => $perpustakaanType->instansi_type_id]);

        // Masjid
        Instansi::create(['name' => 'Masjid A', 'code' => 'MA', 'instansi_type_id' => $masjidType->instansi_type_id]);
        Instansi::create(['name' => 'Masjid B', 'code' => 'MB', 'instansi_type_id' => $masjidType->instansi_type_id]);
        Instansi::create(['name' => 'Masjid C', 'code' => 'MC', 'instansi_type_id' => $masjidType->instansi_type_id]);
    }
}