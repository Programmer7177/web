<?php

namespace App\Http\Controllers;

use App\Models\FacilityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            $pendingCount = FacilityReport::where('status', 'pending')->count();
            $inProgressCount = FacilityReport::where('status', 'in_progress')->count();
            $completedCount = FacilityReport::where('status', 'completed')->count();

            $statusCounts = [
                'pending' => $pendingCount,
                'in_progress' => $inProgressCount,
                'completed' => $completedCount,
            ];

            $startDate = Carbon::today()->subDays(6);
            $rawDaily = FacilityReport::select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(*) as total'))
                ->where('created_at', '>=', $startDate->copy()->startOfDay())
                ->groupBy('d')
                ->orderBy('d')
                ->pluck('total', 'd')
                ->toArray();

            $trendLabels = [];
            $trendCounts = [];
            for ($i = 0; $i < 7; $i++) {
                $date = $startDate->copy()->addDays($i);
                $key = $date->toDateString();
                $trendLabels[] = $date->translatedFormat('d M');
                $trendCounts[] = isset($rawDaily[$key]) ? (int) $rawDaily[$key] : 0;
            }

            $latestReports = FacilityReport::where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();

            // Tampilkan view dashboard mahasiswa yang sudah ada
            return view('dashboard', compact(
                'pendingCount',
                'inProgressCount',
                'completedCount',
                'statusCounts',
                'trendLabels',
                'trendCounts',
                'latestReports'
            ));
        }
    }
}