<?php

namespace App\Http\Controllers;

use App\Models\FacilityReport;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function create(Request $request, FacilityReport $report)
    {
        // Hanya pemilik laporan yang boleh memberi rating dan hanya jika status completed
        abort_unless($report->user_id === Auth::id(), 403);
        abort_unless($report->status === 'completed', 404);

        // Tandai notifikasi sebagai sudah dibaca jika datang dari dropdown notifikasi
        if ($request->has('notify_id')) {
            $notification = Auth::user()->notifications()->where('id', $request->query('notify_id'))->first();
            if ($notification) {
                $notification->markAsRead();
            }
        }

        // Jika sudah pernah memberi rating, redirect ke detail laporan
        $existing = Rating::where('report_id', $report->report_id)
                          ->where('user_id', Auth::id())
                          ->first();
        if ($existing) {
            return redirect()->route('reports.show', $report->report_id)
                ->with('success', 'Terima kasih, Anda sudah memberikan rating.');
        }

        return view('ratings.create', compact('report'));
    }

    public function store(Request $request, FacilityReport $report)
    {
        abort_unless($report->user_id === Auth::id(), 403);
        abort_unless($report->status === 'completed', 404);

        $validated = $request->validate([
            'rating_value' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cegah duplikasi rating oleh user yang sama pada laporan ini
        $alreadyRated = Rating::where('report_id', $report->report_id)
                              ->where('user_id', Auth::id())
                              ->exists();
        if ($alreadyRated) {
            return redirect()->route('reports.show', $report->report_id)
                ->with('success', 'Anda sudah pernah memberikan rating.');
        }

        Rating::create([
            'report_id' => $report->report_id,
            'user_id' => Auth::id(),
            'rating_value' => $validated['rating_value'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()->route('reports.show', $report->report_id)
            ->with('success', 'Terima kasih, rating Anda telah tersimpan.');
    }
}
