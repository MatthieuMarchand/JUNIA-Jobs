<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    protected $primaryKey = 'name';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function studentProfiles(): BelongsToMany
    {
        return $this->belongsToMany(
            StudentProfile::class,
            'student_profile_skills',
            'skill_name',
            'student_profile_id'
        );
    }
}
