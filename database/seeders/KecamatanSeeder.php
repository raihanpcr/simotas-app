<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Kecamatan A'],
            ['nama' => 'Kecamatan B'],
            ['nama' => 'Kecamatan C'],
        ];

        foreach ($data as $item) {
            Kecamatan::create($item);
        }
    }
}
