<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopReport extends Model
{
    /** @use HasFactory<\Database\Factories\WorkshopReportFactory> */
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'extra_activities'    => 'boolean',
        'materials_provided' => 'boolean',
        'grid_provided'       => 'boolean',
    ];


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
        return $this->belongsTo(User::class, 'instructor_id')
                    ->withTrashed();
    }

    public function getInstructorNameAttribute(){
        return $this->instructor ? $this->instructor->name : 'Instrutor não encontrado';
    }
    public function schoolClasses()
    {
        return $this->hasMany(WorkshopReportSchoolClass::class, 'workshop_report_id');
    }

    public function getUniqueWorkshopsCountAttribute()
    {   
        // Conta o número de oficinas únicas baseadas no horário no mes atual
    
        return $this->schoolClasses
            ->pluck('time')    // pega todos os horários desse relatório
            ->unique()         // remove duplicados
            ->count();         // conta oficinas únicas
    }

    public function getDayofWeekAttribute()
    {
         return mb_strtoupper(
            Carbon::parse($this->report_date)
                ->locale('pt_BR')
                ->isoFormat('dddd')
        );

    }
    public function getFormattedReportDateAttribute()
    {
        return Carbon::parse($this->report_date)->format('d/m/Y');
    }


}
