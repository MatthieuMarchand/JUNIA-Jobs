<?php

namespace App\Models;

use Database\Factories\AcademicRecordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicRecord extends Model
{
    /** @use HasFactory<AcademicRecordFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'student_profile_id',
        'degree',
        'institution',
        'start',
        'end',
        'description',
    ];

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
    ];

    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }
}
