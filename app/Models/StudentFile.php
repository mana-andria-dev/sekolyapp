<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class StudentFile extends Model
{
	use BelongsToTenant;
	
    protected $fillable = ['student_id', 'name', 'file_path', 'description'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
