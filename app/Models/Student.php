<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Builder;

class Student extends Model
{
    use HasFactory;
    use Notifiable;
    use BelongsToTenant;
    
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

    protected $hidden = ['password', 'remember_token'];

    protected static function booted()
    {
        static::addGlobalScope(new TenantScope);
    }
    
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

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'assignment_student')
                    ->withPivot(['status', 'grade', 'submitted_at'])
                    ->withTimestamps();
    }    
    
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    
}
