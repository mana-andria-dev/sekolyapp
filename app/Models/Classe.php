<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ← ajoute ceci
use App\Models\Traits\BelongsToTenant;

class Classe extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = ['tenant_id', 'name', 'level', 'description'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_student', 'class_id', 'student_id')
                    ->withTimestamps();
    }

    public function teachers()
    {
        return $this->belongsToMany(
            Teacher::class,
            'class_teacher',
            'class_id',
            'teacher_id'
        );
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'class_subject', // table pivot
            'class_id',      // clé étrangère du modèle Classe dans la table pivot
            'subject_id'     // clé étrangère du modèle Subject dans la table pivot
        );
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'class_id');
    }        
}
