<?php

namespace App\Http\Controllers;

use App\Models\FacilityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek peran pengguna yang sedang login
        if (Auth::user()->role->name == 'admin_sarpras') {
        
            // --- LOGIKA UNTUK ADMIN ---
            // Ambil semua laporan untuk ditampilkan di tabel
            $reports = \App\Models\FacilityReport::with(['reporter', 'category', 'instansi'])
                                                 ->latest()
                                                 ->paginate(10);
                                             
            // Tampilkan view dashboard admin
            return view('admin.dashboard', compact('reports'));

        } else {

            // --- LOGIKA UNTUK MAHASISWA (PENGGUNA BIASA) ---
            // Ambil data statistik seperti sebelumnya
            $pendingCount = \App\Models\FacilityReport::where('status', 'pending')->count();
            $inProgressCount = \App\Models\FacilityReport::where('status', 'in_progress')->count();
            $completedCount = \App\Models\FacilityReport::where('status', 'completed')->count();

            // Tampilkan view dashboard mahasiswa yang sudah ada
            return view('dashboard', compact('pendingCount', 'inProgressCount', 'completedCount'));
        }
    }
}