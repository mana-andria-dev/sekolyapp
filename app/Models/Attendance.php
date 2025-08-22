<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class Attendance extends Model
{
	use BelongsToTenant;
	
    protected $fillable = ['student_id', 'date', 'status', 'notes'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
