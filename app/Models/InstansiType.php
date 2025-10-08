<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstansiType extends Model
{
    use HasFactory;

    protected $primaryKey = 'instansi_type_id';

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get all instansi for this type.
     */
    public function instansi()
    {
        return $this->hasMany(Instansi::class, 'instansi_type_id');
    }

    /**
     * Get all facility reports for this instansi type.
     */
    public function facilityReports()
    {
        return $this->hasMany(FacilityReport::class, 'instansi_type_id');
    }
}