<?php

use Illuminate\Support\Facades\Route;
use App\Models\FacilityReport;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacilityReportController;
use App\Http\Controllers\ReportCommentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RatingController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Halaman utama (untuk tamu)
Route::get('/', function () {
    $pendingCount = FacilityReport::where('status', 'pending')->count();
    $inProgressCount = FacilityReport::where('status', 'in_progress')->count();
    $completedCount = FacilityReport::where('status', 'completed')->count();

    return view('welcome', compact('pendingCount', 'inProgressCount', 'completedCount'));
});

// 📊 Endpoint publik untuk statistik laporan (tanpa login)
Route::get('/public/stats', function () {
    return response()->json([
        'pending' => FacilityReport::where('status', 'pending')->count(),
        'in_progress' => FacilityReport::where('status', 'in_progress')->count(),
        'completed' => FacilityReport::where('status', 'completed')->count(),
        'updated_at' => now()->toIso8601String(),
    ]);
})->name('public.stats');

// 🔒 Grup route yang hanya bisa diakses setelah login & verifikasi email
Route::middleware(['auth', 'verified'])->group(function () {

    // 📁 Dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 📤 Ekspor data laporan ke CSV
    Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');

    // 🧾 CRUD untuk laporan fasilitas
    Route::resource('reports', FacilityReportController::class);
    
    // AJAX endpoint untuk mendapatkan instansi berdasarkan type
    Route::get('reports/get-instansi-by-type', [FacilityReportController::class, 'getInstansiByType'])->name('reports.get-instansi-by-type');

    // 💬 Komentar untuk laporan
    Route::post('reports/{report}/comments', [ReportCommentController::class, 'store'])->name('comments.store');

    // Route untuk menyimpan rating laporan yang telah selesai
    Route::post('reports/{report}/rating', [RatingController::class, 'store'])->name('reports.rating.store');
    
    // ℹ️ Halaman tentang layanan
    Route::get('/tentang-layanan', [PageController::class, 'about'])->name('pages.about');
});

// 🔐 Route untuk login, register, lupa password, dll (Breeze)
require __DIR__ . '/auth.php';
