<?php

namespace Database\Seeders;

use App\Models\Warga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class WargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $kategoriList = ['Disabilitas', 'Yatim', 'Lansia'];

        for ($i = 0; $i < 10; $i++) {
            // Generate NIK unik
            do {
                $nik = $faker->numerify('################'); // 16 digit
            } while (Warga::where('nik', $nik)->exists());

            Warga::create([
                'nik' => $nik,
                'name' => $faker->name,
                'place_of_birth' => $faker->city,
                'date_of_birth' => $faker->date('Y-m-d', '2010-01-01'), // tanggal lahir sebelum 2010
                'umur' => rand(10, 80),
                'alamat' => $faker->address,
                'kategori' => $kategoriList[array_rand($kategoriList)],
            ]);
        }
    }
}
