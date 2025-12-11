<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SchoolClass extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolClassFactory> */
    use HasFactory, SoftDeletes;
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'grade',
        'school_class_origin_id',
    ];

    public function origin()
    {
        return $this->belongsTo(SchoolClassOrigin::class, 'school_class_origin_id');
    }
    
    public function reports()
    {
        return $this->hasMany(WorkshopReportSchoolClass::class, 'school_class_id');
    }

    public function instructorsWithWorkshopCount()
    {
        return $this->hasManyThrough(
            WorkshopReport::class,
            WorkshopReportSchoolClass::class,
            'school_class_id', // FK em WorkshopReportSchoolClass
            'id', // FK em WorkshopReport (id do workshop_report)
            'id', // PK SchoolClass
            'workshop_report_id' // PK WorkshopReportSchoolClass
        )
        ->join('users', 'workshop_reports.instructor_id', '=', 'users.id')
        ->select(
            'workshop_reports.instructor_id',
            'users.name as instructor_name', // Adicionando o nome do oficineiro
            DB::raw('COUNT(DISTINCT workshop_reports.id) as total_workshops')
        )
        ->groupBy('workshop_reports.instructor_id', 'users.name');
    }

    public function recentWorkshopsByUser($limit = 7)
    {
        $userId = Auth::user()->id;
        return $this->hasManyThrough(
            WorkshopReport::class,
            WorkshopReportSchoolClass::class,
            'school_class_id',
            'id',
            'id',
            'workshop_report_id'
        )
        ->where('workshop_reports.instructor_id', $userId)
        ->orderBy('workshop_reports.report_date', 'desc')
        ->limit($limit)
        ->select('workshop_reports.*');
    }

}
