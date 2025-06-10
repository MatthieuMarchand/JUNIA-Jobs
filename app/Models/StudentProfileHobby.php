<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfileHobby extends Model
{
    public $timestamps = false;

    protected $table = 'student_profile_hobbies';

    protected $fillable = [
        'student_profile_id',
        'hobby_name',
    ];

    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }
}
