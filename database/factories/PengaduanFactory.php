<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PengaduanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'judul' => fake()->sentence(),
            'deskripsi' => fake()->paragraph(),
            'nomor_tiket' => 'TKT-' . date('YmdHis') . Str::random(5),
            'status' => fake()->randomElement(['Menunggu Tanggapan', 'Diproses', 'Selesai']),
            'lampiran' => null,
        ];
    }
}
