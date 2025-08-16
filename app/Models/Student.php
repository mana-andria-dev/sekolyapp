<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'tenant_id',
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'address',
        'phone',
        'email',
        'enrollment_date',
        'status',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function files()
    {
        return $this->hasMany(StudentFile::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'class_student', 'student_id', 'class_id')
                    ->withTimestamps();
    }
    
}
