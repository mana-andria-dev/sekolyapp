<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class Subject extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = ['tenant_id', 'name', 'description'];

    // Une matière appartient à plusieurs classes
    public function classes()
    {
        return $this->belongsToMany(
            Classe::class,
            'class_subject',
            'subject_id',
            'class_id'
        );
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }    

    // Une matière peut avoir plusieurs devoirs
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
