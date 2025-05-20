<?php

namespace App\Models;

use Database\Factories\StudentProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class StudentProfile extends Model
{
    /** @use HasFactory<StudentProfileFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'photo_path',
        'summary',
        'phone_number',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function temporaryPhotoUrl(): string|null
    {
        if (is_null($this->photo_path)) {
            return null;
        }

        return Storage::temporaryUrl($this->photo_path, now()->addMinute());
    }

    public function researchAreas(): BelongsToMany
    {
        return $this->belongsToMany(ResearchArea::class, 'student_profile_research_areas');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'student_profile_skills');
    }
}
