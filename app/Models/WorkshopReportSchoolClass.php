<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopReportSchoolClass extends Model
{
    /** @use HasFactory<\Database\Factories\WorkshopReportSchoolClassFactory> */
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'time',
        'workshop_report_id',
        'school_class_id',
        'workshop_theme',
    ];

    public function workshopReport()
    {
        return $this->belongsTo(WorkshopReport::class, 'workshop_report_id');
    }
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
}
