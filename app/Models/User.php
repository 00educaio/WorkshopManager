<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasUuids;


    protected $keyType = 'string';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'cpf',
        'phone',
        'avatar',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function workshopReports()
    {
        return $this->hasMany(WorkshopReport::class, 'instructor_id');
    }

    public function getAvatarImgAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('default-avatar.png');
    }
    
    //ENTENDER MELHOR TUDO ISSO AQUI ABAIXO
    public function workshopReportSchoolClasses()
    {
        return $this->hasManyThrough(
            WorkshopReportSchoolClass::class,
            WorkshopReport::class,
            'instructor_id',         // chave no workshop_reports
            'workshop_report_id',    // chave no workshop_report_school_classes
            'id',
            'id'
        );
    }

    public function getUniqueWorkshopsCountAttribute()
    {
        return $this->workshopReportSchoolClasses
            ->groupBy('workshop_report_id')  // separa por relatório
            ->map(function ($classes) {
                return $classes->pluck('time')->unique()->count(); // conta horários únicos no relatório
            })
            ->sum(); // soma horários únicos de todos os relatórios
    }


    public function schoolClassesWithCount()
    {
        return $this->hasManyThrough(
            WorkshopReportSchoolClass::class,
            WorkshopReport::class,
            'instructor_id', // FK em WorkshopReport
            'workshop_report_id', // FK em WorkshopReportSchoolClass
            'id', // PK User
            'id'  // PK WorkshopReport
        )
        ->select(
            'school_class_id',
            DB::raw("COUNT(DISTINCT workshop_report_id || '_' || time) as total")
        )
        ->groupBy('school_class_id');
    }
}
