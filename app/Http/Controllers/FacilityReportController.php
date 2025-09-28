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
        $reports = FacilityReport::latest()->paginate(10);
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
        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'instansi_id' => 'required|exists:instansi,instansi_id',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        // Tambahkan aturan validasi status HANYA jika pengguna adalah admin
        if (Auth::user()->role->name == 'admin_sarpras') {
            $rules['status'] = 'required|string';
        }

        $request->validate($rules);

        // Ambil semua data kecuali status dan attachment
        $dataToUpdate = $request->except(['status', 'attachment']);

        // Update status HANYA jika pengguna adalah admin
        if (Auth::user()->role->name == 'admin_sarpras') {
            $dataToUpdate['status'] = $request->status;
        }
    
        // Logika untuk menangani update file lampiran
        if ($request->hasFile('attachment')) {
            if ($report->attachment_path) {
                Storage::disk('public')->delete($report->attachment_path);
            }
            $filePath = $request->file('attachment')->store('attachments', 'public');
            $dataToUpdate['attachment_path'] = $filePath;
        }

        $report->update($dataToUpdate);

        return redirect()->route('reports.index')
                         ->with('success', 'Laporan berhasil diperbarui!');
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

        return redirect()->route('reports.index')
                         ->with('success', 'Laporan berhasil dihapus!');
    }
}