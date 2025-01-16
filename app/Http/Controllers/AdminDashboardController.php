<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{

    public function index()
    {
        // Stats untuk cards
        $stats = [
            'total' => Pengaduan::count(),
            'menunggu' => Pengaduan::where('status', 'Menunggu Tanggapan')->count(),
            'diproses' => Pengaduan::where('status', 'Diproses')->count(),
            'selesai' => Pengaduan::where('status', 'Selesai')->count(),
        ];

        // Pengaduan terbaru
        $recentPengaduans = Pengaduan::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPengaduans'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['user', 'tanggapans.user']);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function storeTanggapan(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'tanggapan' => 'required|string'
        ]);

        $tanggapan = $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'tanggapan' => $request->tanggapan
        ]);

        // Update status pengaduan
        $pengaduan->update(['status' => 'Diproses']);

        return redirect()->back()->with('success', 'Tanggapan berhasil ditambahkan');
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Tanggapan,Diproses,Selesai'
        ]);

        $pengaduan->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui');
    }
}
