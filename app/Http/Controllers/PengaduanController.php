<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{

    public function index()
    {
        $pengaduans = Pengaduan::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['nomor_tiket'] = 'TKT-' . date('YmdHis') . Str::random(5);
        $data['status'] = 'Menunggu Tanggapan';

        if ($request->hasFile('lampiran')) {
            $lampiran = $request->file('lampiran');
            $filename = time() . '_' . $lampiran->getClientOriginalName();
            $lampiran->storeAs('public/lampiran', $filename);
            $data['lampiran'] = $filename;
        }

        Pengaduan::create($data);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function show(Pengaduan $pengaduan)
    {
        $this->authorize('view', $pengaduan);
        return view('pengaduan.show', compact('pengaduan'));
    }

    public function edit(Pengaduan $pengaduan)
    {
        $this->authorize('update', $pengaduan);
        return view('pengaduan.edit', compact('pengaduan'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $this->authorize('update', $pengaduan);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only(['judul', 'deskripsi']);

        if ($request->hasFile('lampiran')) {
            if ($pengaduan->lampiran) {
                Storage::delete('public/lampiran/' . $pengaduan->lampiran);
            }

            $lampiran = $request->file('lampiran');
            $filename = time() . '_' . $lampiran->getClientOriginalName();
            $lampiran->storeAs('public/lampiran', $filename);
            $data['lampiran'] = $filename;
        }

        $pengaduan->update($data);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        $this->authorize('delete', $pengaduan);

        if ($pengaduan->lampiran) {
            Storage::delete('public/lampiran/' . $pengaduan->lampiran);
        }

        $pengaduan->delete();

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }
}
