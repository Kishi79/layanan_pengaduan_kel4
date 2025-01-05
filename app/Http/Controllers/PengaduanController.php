<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::all();
        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $nomorTiket = strtoupper(Str::random(10));

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran', 'public');
        }

        Pengaduan::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'lampiran' => $lampiranPath,
            'nomor_tiket' => $nomorTiket,
            'status' => 'Menunggu Tanggapan',
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim!');
    }
    public function show($id)
{
    $pengaduan = Pengaduan::findOrFail($id); // Cari data pengaduan berdasarkan ID
    return view('pengaduan.show', compact('pengaduan'));
}
public function edit($id)
{
    $pengaduan = Pengaduan::findOrFail($id); // Cari data pengaduan berdasarkan ID
    return view('pengaduan.edit', compact('pengaduan'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
    ]);

    $pengaduan = Pengaduan::findOrFail($id);
    $pengaduan->update([
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
    ]);

    return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
}
public function destroy($id)
{
    $pengaduan = Pengaduan::findOrFail($id);
    $pengaduan->delete();

    return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
}

}
