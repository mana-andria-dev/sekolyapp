<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'tenant_id', 'subject_id', 'class_id', 'teacher_id',
        'title', 'type', 'date', 'max_score', 'created_by'
    ];

    // 🔗 Relations
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function grades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
