<?php

namespace App\Http\Controllers;

use App\Models\FacilityReport;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Simpan rating untuk laporan yang sudah completed.
     */
    public function store(Request $request, FacilityReport $report)
    {
        // Hanya pelapor yang boleh memberikan rating
        if (Auth::id() !== $report->user_id) {
            abort(403, 'Anda tidak berhak memberi rating untuk laporan ini.');
        }

        if ($report->status !== 'completed') {
            return redirect()->route('reports.show', $report->report_id)
                ->with('error', 'Rating hanya bisa diberikan untuk laporan yang sudah selesai.');
        }

        $request->validate([
            'rating_value' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cegah user memberikan rating lebih dari sekali pada laporan yang sama
        $existing = Rating::where('report_id', $report->report_id)
            ->where('user_id', Auth::id())
            ->first();
        if ($existing) {
            return redirect()->route('reports.show', $report->report_id)
                ->with('info', 'Anda sudah memberikan rating pada laporan ini.');
        }

        Rating::create([
            'report_id' => $report->report_id,
            'user_id' => Auth::id(),
            'rating_value' => (int) $request->rating_value,
            'comment' => $request->comment,
        ]);

        return redirect()->route('reports.show', $report->report_id)
            ->with('success', 'Terima kasih! Rating Anda telah tersimpan.');
    }
}
