<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class Submission extends Model
{
	use BelongsToTenant;
	
    protected $fillable = ['assignment_id','student_id','answer','file_path','grade','feedback'];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }
}
