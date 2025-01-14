<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{

    public function index()
    {
        $pengaduans = Pengaduan::with(['user', 'tanggapans'])
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact('pengaduans'));
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
