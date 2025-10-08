<?php

namespace App\Http\Controllers;

use App\Models\FacilityReport;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Cek peran pengguna yang sedang login
        if (Auth::user()->role->name == 'admin_sarpras') {
        
            // --- LOGIKA UNTUK ADMIN ---
            // Ambil filter dari query string
            $search = $request->string('q')->toString();
            $categoryId = $request->integer('category_id') ?: null;
            $status = $request->string('status')->toString();

            // Query dasar dengan relasi untuk menghindari N+1
            $query = FacilityReport::with(['reporter', 'category', 'instansi', 'ratings'])->latest();

            // Terapkan filter opsional
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            }
            if (!empty($categoryId)) {
                $query->where('category_id', $categoryId);
            }
            if (!empty($status)) {
                $query->where('status', $status);
            }

            $reports = $query->paginate(10)->withQueryString();

            // Data metrik ringkas
            $metrics = [
                'total' => FacilityReport::count(),
                'pending' => FacilityReport::where('status', 'pending')->count(),
                'in_progress' => FacilityReport::where('status', 'in_progress')->count(),
                'completed' => FacilityReport::where('status', 'completed')->count(),
            ];

            // Data referensi filter
            $categories = Category::orderBy('name')->get();

            // Tampilkan view dashboard admin
            return view('admin.dashboard', compact('reports', 'metrics', 'categories', 'search', 'categoryId', 'status'));

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

    public function export(Request $request)
    {
        // Hanya admin yang boleh ekspor
        if (Auth::user()->role->name !== 'admin_sarpras') {
            abort(403);
        }

        $search = $request->string('q')->toString();
        $categoryId = $request->integer('category_id') ?: null;
        $status = $request->string('status')->toString();

        $query = FacilityReport::with(['reporter', 'category', 'instansi'])->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }
        if (!empty($status)) {
            $query->where('status', $status);
        }

        $reports = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan_fasilitas.csv"',
        ];

        $columns = [
            'No. Laporan', 'Nama Pelapor', 'Kategori', 'Instansi', 'Judul', 'Lokasi', 'Tanggal', 'Status', 'Deskripsi'
        ];

        $callback = function () use ($reports, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($reports as $report) {
                fputcsv($file, [
                    '#' . $report->report_id,
                    optional($report->reporter)->username ?? 'N/A',
                    optional($report->category)->name ?? 'N/A',
                    optional($report->instansi)->name ?? 'N/A',
                    $report->title,
                    $report->location,
                    optional($report->created_at)?->format('d M Y'),
                    $report->status,
                    $report->description,
                ]);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'laporan_fasilitas.csv', $headers);
    }
}