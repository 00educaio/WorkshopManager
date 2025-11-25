<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopReport extends Model
{
    /** @use HasFactory<\Database\Factories\WorkshopReportFactory> */
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'report_date',
        'extra_activities',
        'extra_activities_description',
        'materials_provided',
        'grid_provided',
        'observations', 
        'feedback',
        'instructor_id',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
    public function schoolClasses()
    {
        return $this->hasMany(WorkshopReportSchoolClass::class, 'workshop_report_id');
    }

    public function getUniqueWorkshopsCountAttribute()
    {
        return $this->schoolClasses
            ->pluck('time')    // pega todos os horários desse relatório
            ->unique()         // remove duplicados
            ->count();         // conta oficinas únicas
    }


}
