<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFile extends Model
{
    protected $fillable = ['student_id', 'name', 'file_path', 'description'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
