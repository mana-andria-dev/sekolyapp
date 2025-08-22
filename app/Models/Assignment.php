<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class Assignment extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = [
        'subject_id', 'class_id', 'teacher_id',
        'title', 'description', 'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // Le devoir appartient à une classe
    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'assignment_student')
            ->withPivot(['status', 'grade', 'submitted_at'])
            ->withTimestamps();
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    
}
