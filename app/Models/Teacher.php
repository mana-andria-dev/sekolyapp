<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class Teacher extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'bio',
        'photo_path',
    ];

    public function classes()
    {
        return $this->belongsToMany(
            Classe::class,
            'class_teacher',
            'teacher_id',
            'class_id'
        );
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }        
}
