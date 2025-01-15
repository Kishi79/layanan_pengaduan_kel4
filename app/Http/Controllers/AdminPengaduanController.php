<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with(['user', 'tanggapans'])
            ->latest()
            ->paginate(10);
        return view('admin.pengaduan.index', compact('pengaduans'));
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

    public function destroy(Pengaduan $pengaduan)
    {
        // Hapus lampiran jika ada
        if ($pengaduan->lampiran) {
            Storage::delete('public/lampiran/' . $pengaduan->lampiran);
        }

        // Hapus pengaduan dan tanggapan terkait (cascade delete di migration)
        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus');
    }
}
