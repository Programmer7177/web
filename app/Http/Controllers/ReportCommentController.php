<?php

    namespace App\Http\Controllers;

    use App\Models\FacilityReport;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class ReportCommentController extends Controller
    {
        public function store(Request $request, FacilityReport $report)
        {
            $request->validate(['body' => 'required|string']);

            $report->comments()->create([
                'user_id' => Auth::id(),
                'body' => $request->body,
            ]);

            return back()->with('success', 'Komentar berhasil ditambahkan.');
        }
    }