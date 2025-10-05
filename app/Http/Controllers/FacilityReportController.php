<?php

namespace App\Http\Controllers;

use App\Models\FacilityReport;
use App\Models\Category;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // PENTING: Tambahkan ini

class FacilityReportController extends Controller
{
    /**
     * Menampilkan daftar semua laporan. (Read)
     */
    public function index()
    {
        // Cek peran user yang sedang login
        if (Auth::user()->role->name == 'admin_sarpras') {
            // Jika admin, tampilkan semua laporan dari yang terbaru
            $reports = FacilityReport::latest()->paginate(10);
        } else {
            // Jika bukan admin (mahasiswa), tampilkan hanya laporannya sendiri
            $reports = FacilityReport::where('user_id', Auth::id())
                                     ->latest()
                                     ->paginate(10);
        }

        return view('reports.index', compact('reports'));
    }

    /**
     * Menampilkan form untuk membuat laporan baru. (Create)
     */
    public function create()
    {
        $categories = Category::all();
        $instansis = Instansi::all();
        return view('reports.create', compact('categories', 'instansis'));
    }

    /**
     * Menyimpan laporan baru ke database. (Create)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'instansi_id' => 'required|exists:instansi,instansi_id',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('attachments', 'public');
        }

        FacilityReport::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'instansi_id' => $request->instansi_id,
            'description' => $request->description,
            'location' => $request->location,
            'user_id' => Auth::id(), // PERBAIKAN: Gunakan ID user yang login
            'status' => 'pending',
            'attachment_path' => $filePath,
        ]);

        return redirect()->route('reports.index')
                         ->with('success', 'Laporan berhasil dibuat!');
    }

    /**
     * Menampilkan detail satu laporan. (Read)
     */
    public function show(FacilityReport $report)
    {
        return view('reports.show', compact('report'));
    }

    /**
     * Menampilkan form untuk mengedit laporan. (Update)
     */
    public function edit(FacilityReport $report)
    {
        $categories = Category::all();
        $instansis = Instansi::all();
        return view('reports.edit', compact('report', 'categories', 'instansis'));
    }

    /**
     * Menyimpan perubahan pada laporan ke database. (Update)
     */
    public function update(Request $request, FacilityReport $report)
    {
        // Cek apakah pengguna adalah admin
        $isAdmin = Auth::user()->role->name == 'admin_sarpras';

        if ($isAdmin) {
            // Aturan validasi HANYA untuk admin
            $rules = [
                'status' => 'required|string',
                'admin_comment' => 'nullable|string',
            ];
        
            $request->validate($rules);
        
            // Data yang diupdate HANYA status
            $dataToUpdate = [
                'status' => $request->status,
            ];

            // Jika ada komentar dari admin, kita akan simpan di langkah selanjutnya
            if ($request->filled('admin_comment')) {
                $report->comments()->create([
                'user_id' => Auth::id(),
                'body' => $request->admin_comment,
                ]);
            }

        } else {
            // Aturan validasi untuk user biasa (sama seperti sebelumnya)
            $rules = [
                'title' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,category_id',
                'instansi_id' => 'required|exists:instansi,instansi_id',
                'description' => 'required|string',
                'location' => 'required|string|max:255',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ];
        
            $request->validate($rules);
            $dataToUpdate = $request->except(['attachment']);
        }

        // Logika untuk menangani update file lampiran (hanya untuk user)
        if (!$isAdmin && $request->hasFile('attachment')) {
            if ($report->attachment_path) {
                Storage::disk('public')->delete($report->attachment_path);
            }
            $filePath = $request->file('attachment')->store('attachments', 'public');
            $dataToUpdate['attachment_path'] = $filePath;
        }

        $report->update($dataToUpdate);

        // Redirect ke halaman yang sesuai
        if ($isAdmin) {
            return redirect()->route('dashboard')->with('success', 'Status laporan berhasil diperbarui!');
        } else {
            return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui!');
        }
    }

    /**
     * Menghapus laporan dari database. (Delete)
     */
    public function destroy(FacilityReport $report)
    {
        if ($report->attachment_path) {
            Storage::disk('public')->delete($report->attachment_path);
        }

        $report->delete();

        // REVISI: Tambahkan logika redirect berdasarkan peran
        if (Auth::user()->role->name == 'admin_sarpras') {
            // Jika admin, kembalikan ke dashboard admin
            return redirect()->route('dashboard')
                             ->with('success', 'Laporan berhasil dihapus!');
        } else {
            // Jika user biasa, kembalikan ke daftar laporannya sendiri
            return redirect()->route('reports.index')
                             ->with('success', 'Laporan berhasil dihapus!');
        }
}


}