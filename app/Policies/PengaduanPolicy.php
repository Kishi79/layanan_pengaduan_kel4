<?php

namespace App\Policies;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengaduanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Semua user bisa lihat daftar pengaduan mereka
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pengaduan $pengaduan): bool
    {
        return $user->id === $pengaduan->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Semua user bisa buat pengaduan
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pengaduan $pengaduan): bool
    {
        return $user->id === $pengaduan->user_id && $pengaduan->status === 'Menunggu Tanggapan';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pengaduan $pengaduan): bool
    {
        return $user->id === $pengaduan->user_id && $pengaduan->status === 'Menunggu Tanggapan';
    }
}
