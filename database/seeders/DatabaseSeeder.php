<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pengaduan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat admin iye bim
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory(5)->create();

        // Buat pengaduan iye bim
        Pengaduan::factory(10)->create([
            'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id
        ]);
    }
}
