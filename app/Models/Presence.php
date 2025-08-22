<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\BelongsToTenant;

class Presence extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'student_id',
        'date',
        'status',
        'remarques',
    ];

    // Relation avec le tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Relation avec l'étudiant
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
