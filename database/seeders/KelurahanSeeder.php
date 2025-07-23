<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatan = Kecamatan::first();
        if ($kecamatan) {
            $kecamatan = Kecamatan::create(['nama' => 'Kecamatan Default']);
        }

        $kelurahanList = [
            ['nama' => 'Kelurahan 1', 'kecamatan_id' => $kecamatan->id],
            ['nama' => 'Kelurahan 2', 'kecamatan_id' => $kecamatan->id],
            ['nama' => 'Kelurahan 3', 'kecamatan_id' => $kecamatan->id],
        ];

        foreach ($kelurahanList as $kelurahan) {
            Kelurahan::create($kelurahan);
        }
    }
}
