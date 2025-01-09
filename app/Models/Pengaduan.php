<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'deskripsi', 'lampiran', 'nomor_tiket', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
