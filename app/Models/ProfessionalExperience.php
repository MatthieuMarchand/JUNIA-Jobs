<?php

namespace App\Models;

use Database\Factories\ProfessionalExperienceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfessionalExperience extends Model
{
    /** @use HasFactory<ProfessionalExperienceFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "title",
        "contract_type",
        "company_name",
        "location",
        "start",
        "end",
        "description",
    ];

    protected $casts = [
        "start" => "date",
        "end" => "date",
    ];

    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }
}
