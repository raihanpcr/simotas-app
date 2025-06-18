<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
        ]);

        // Kepala Dinas (misal id district 1)
        User::create([
            'name' => 'Kepala Dinas',
            'username' => 'kepaladinas',
            'password' => Hash::make('password123'),
            'role' => 'kepala_dinas',
        ]);

        // Kepala Desa (misal id desa 1)
        User::create([
            'name' => 'Kepala Desa',
            'username' => 'kepaladesa',
            'password' => Hash::make('password123'),
            'role' => 'kepala_desa',
        ]);
    }
}
