<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'student_profile_id',
        'title',
        'date_obtained',
        'description',
        'link',
    ];

    protected $casts = [
        'date_obtained' => 'date',
    ];

    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }
}
