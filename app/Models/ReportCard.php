<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'evaluation_id', // Assure-toi que cette colonne existe
        'general_average',
        'appreciation',
        'term',
        'year',
        'tenant_id',
    ];

    // Relation avec l'étudiant
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relation avec l'évaluation
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}
