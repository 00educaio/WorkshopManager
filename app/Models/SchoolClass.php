<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolClassFactory> */
    use HasFactory;
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
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

}
