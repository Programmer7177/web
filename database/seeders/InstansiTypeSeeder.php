<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InstansiType;

class InstansiTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instansiTypes = [
            [
                'name' => 'Fakultas',
                'description' => 'Fakultas-fakultas di universitas'
            ],
            [
                'name' => 'Perpustakaan',
                'description' => 'Perpustakaan dan unit terkait'
            ],
            [
                'name' => 'Masjid',
                'description' => 'Masjid dan unit keagamaan'
            ]
        ];

        foreach ($instansiTypes as $type) {
            InstansiType::create($type);
        }
    }
}