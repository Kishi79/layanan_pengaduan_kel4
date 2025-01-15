<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalPengaduan = Pengaduan::where('user_id', $user->id)->count();
        $pengaduanDiproses = Pengaduan::where('user_id', $user->id)
            ->where('status', 'Diproses')
            ->count();
        $pengaduanSelesai = Pengaduan::where('user_id', $user->id)
            ->where('status', 'Selesai')
            ->count();

        $recentPengaduans = Pengaduan::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPengaduan',
            'pengaduanDiproses',
            'pengaduanSelesai',
            'recentPengaduans'
        ));
    }
}
