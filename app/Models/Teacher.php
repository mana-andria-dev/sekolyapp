<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

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
        return $this->belongsToMany(Classe::class, 'class_teacher');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }    
}
