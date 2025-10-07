<?php

namespace App\Notifications;

use App\Models\FacilityReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportStatusUpdated extends Notification
{
    use Queueable;

    public $report;

    public function __construct(FacilityReport $report)
    {
        $this->report = $report;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Kirim notifikasi ke database
    }

    public function toDatabase(object $notifiable): array
    {
        $isCompleted = $this->report->status === 'completed';
        return [
            'message' => $isCompleted
                ? 'Laporan "' . $this->report->title . '" telah selesai. Beri rating pengalaman Anda.'
                : 'Status laporan "' . $this->report->title . '" telah diubah menjadi ' . $this->report->status . '.',
            'url' => $isCompleted
                ? route('ratings.create', $this->report->report_id)
                : route('reports.show', $this->report->report_id),
        ];
    }
}