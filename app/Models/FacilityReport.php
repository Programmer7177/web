<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityReport extends Model
{
    use HasFactory;

    protected $primaryKey = 'report_id';

    protected $fillable = [
        'user_id',
        'category_id',
        'asset_id',
        'instansi_id',
        'instansi_type_id',
        'assigned_to',
        'title',
        'description',
        'location',
        'status',
        'attachment_path',
    ];

    /**
     * Laporan ini dibuat oleh satu User (Pelapor).
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Laporan ini ditugaskan ke satu User (Petugas).
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Laporan ini masuk dalam satu Kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Laporan ini mungkin terkait dengan satu Asset.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
    
    /**
     * Sebuah laporan memiliki banyak update status.
     */
    public function statusUpdates()
    {
        return $this->hasMany(StatusUpdate::class, 'report_id');
    }

    /**
     * TAMBAHKAN FUNGSI INI
     * Laporan ini terkait dengan satu Instansi.
     */
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }

    /**
     * Laporan ini terkait dengan satu InstansiType.
     */
    public function instansiType()
    {
        return $this->belongsTo(InstansiType::class, 'instansi_type_id');
    }

    public function comments()
    {
        return $this->hasMany(ReportComment::class, 'facility_report_id');
    }

    /**
     * Daftar rating untuk laporan ini.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'report_id');
    }
}
