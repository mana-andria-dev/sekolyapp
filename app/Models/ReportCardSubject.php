<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class ReportCardSubject extends Model
{
    use BelongsToTenant;
    
    protected $fillable = [
        'report_card_id', 'subject_id', 'average', 'teacher_remark'
    ];

    // 🔗 Relations
    public function reportCard()
    {
        return $this->belongsTo(ReportCard::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
