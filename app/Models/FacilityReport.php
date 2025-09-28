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
        'assigned_to',
        'title',
        'description',
        'location',
        'status',
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
}