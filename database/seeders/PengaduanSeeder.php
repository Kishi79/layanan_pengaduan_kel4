<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengaduanSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        Pengaduan::create([
            'user_id' => $user->id,
            'nomor_tiket' => 'TKT-' . date('YmdHis'),
            'judul' => 'Pengaduan Test',
            'deskripsi' => 'Ini adalah pengaduan test',
            'status' => 'Menunggu Tanggapan'
        ]);
    }
}
