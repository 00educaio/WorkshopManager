<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClassOrigin extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolClassOriginFactory> */
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
    ];

    public function schoolClasses()
    {
        return $this->hasMany(SchoolClass::class, 'school_class_origin_id');
    }
}
