<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class AdminPengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::with(['user', 'tanggapans']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter berdasarkan user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Pencarian berdasarkan nomor tiket, judul, atau deskripsi
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nomor_tiket', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('judul', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Sorting
        $sortField = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        $query->orderBy($sortField, $sortOrder);

        // Get statistics for dashboard cards
        $stats = [
            'total' => Pengaduan::count(),
            'menunggu' => Pengaduan::where('status', 'Menunggu Tanggapan')->count(),
            'diproses' => Pengaduan::where('status', 'Diproses')->count(),
            'selesai' => Pengaduan::where('status', 'Selesai')->count(),
        ];

        // Get users for filter dropdown
        $users = User::where('role', 'user')->get();

        $pengaduans = $query->paginate(10)->withQueryString();

        return view('admin.pengaduan.index', compact(
            'pengaduans',
            'stats',
            'users',
            'request'
        ));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['user', 'tanggapans.user']);

        // Get related pengaduan (same user)
        $relatedPengaduans = Pengaduan::where('user_id', $pengaduan->user_id)
            ->where('id', '!=', $pengaduan->id)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.pengaduan.show', compact('pengaduan', 'relatedPengaduans'));
    }

    public function storeTanggapan(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'tanggapan' => 'required|string|max:1000'
        ]);

        $tanggapan = $pengaduan->tanggapans()->create([
            'user_id' => auth()->id(),
            'tanggapan' => $request->tanggapan
        ]);

        // Update status pengaduan jika belum diproses
        if ($pengaduan->status === 'Menunggu Tanggapan') {
            $pengaduan->update(['status' => 'Diproses']);
        }

        return redirect()->back()->with('success', 'Tanggapan berhasil ditambahkan');
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Tanggapan,Diproses,Selesai'
        ]);

        $oldStatus = $pengaduan->status;
        $pengaduan->update(['status' => $request->status]);

        // Jika status diubah menjadi selesai, tambahkan tanggapan otomatis
        if ($request->status === 'Selesai' && $oldStatus !== 'Selesai') {
            $pengaduan->tanggapans()->create([
                'user_id' => auth()->id(),
                'tanggapan' => 'Pengaduan telah diselesaikan.'
            ]);
        }

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui');
    }

    public function export(Request $request)
    {
        $query = Pengaduan::with(['user', 'tanggapans']);


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nomor_tiket', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('judul', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        $pengaduans = $query->get();

        // Generate CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pengaduan-'.date('Y-m-d').'.csv"',
        ];

        $callback = function() use ($pengaduans) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Nomor Tiket',
                'Pelapor',
                'Judul',
                'Deskripsi',
                'Status',
                'Tanggal Dibuat',
                'Tanggal Update'
            ]);

            // Add data
            foreach ($pengaduans as $pengaduan) {
                fputcsv($file, [
                    $pengaduan->nomor_tiket,
                    $pengaduan->user->name,
                    $pengaduan->judul,
                    $pengaduan->deskripsi,
                    $pengaduan->status,
                    $pengaduan->created_at->format('d/m/Y H:i'),
                    $pengaduan->updated_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function destroy(Pengaduan $pengaduan)
    {
        if ($pengaduan->lampiran) {
            Storage::delete('public/lampiran/' . $pengaduan->lampiran);
        }

        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus');
    }
}
