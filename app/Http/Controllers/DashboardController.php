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
            // KPI counts
            $pendingCount = FacilityReport::where('status', 'pending')->count();
            $inProgressCount = FacilityReport::where('status', 'in_progress')->count();
            $completedCount = FacilityReport::where('status', 'completed')->count();
            $totalReports = FacilityReport::count();

            // Daily trend (last 7 days)
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

            // Group by category for doughnut chart
            $byCategory = FacilityReport::select('category_id', DB::raw('COUNT(*) as total'))
                ->groupBy('category_id')
                ->with('category:id,name')
                ->get()
                ->map(function ($row) {
                    return [
                        'label' => optional($row->category)->name ?? 'Tanpa Kategori',
                        'value' => (int) $row->total,
                    ];
                });

            // Recent reports table
            $reports = FacilityReport::with(['reporter', 'category', 'instansi'])
                ->latest()
                ->paginate(10);

            return view('admin.dashboard', compact(
                'reports',
                'pendingCount', 'inProgressCount', 'completedCount', 'totalReports',
                'trendLabels', 'trendCounts',
                'byCategory'
            ));

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