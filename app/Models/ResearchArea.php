<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ResearchArea extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

    public function studentProfiles(): BelongsToMany
    {
        return $this->belongsToMany(StudentProfile::class, 'student_profile_research_areas');
    }
}
