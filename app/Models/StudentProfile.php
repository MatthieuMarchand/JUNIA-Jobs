<?php

namespace App\Models;

use Database\Factories\StudentProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudentProfile extends Model
{
    /** @use HasFactory<StudentProfileFactory> */
    use HasFactory;

    use Traits\HasPhoto;

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

    public function contractTypes(): BelongsToMany
    {
        return $this->belongsToMany(ContractType::class, 'student_profile_contract_types');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'student_profile_skills');
    }

    public function domains(): BelongsToMany
    {
        return $this->belongsToMany(Domain::class, 'student_profile_domains');
    }
}
