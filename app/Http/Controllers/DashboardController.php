<?php

namespace App\Http\Controllers;

use App\Models\FacilityReport;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah laporan berdasarkan status
        $pendingCount = FacilityReport::where('status', 'pending')->count();
        $inProgressCount = FacilityReport::where('status', 'in_progress')->count();
        $completedCount = FacilityReport::where('status', 'completed')->count();

        // Mengirim data hitungan ke view 'dashboard'
        return view('dashboard', [
            'pendingCount' => $pendingCount,
            'inProgressCount' => $inProgressCount,
            'completedCount' => $completedCount
        ]);
    }
}