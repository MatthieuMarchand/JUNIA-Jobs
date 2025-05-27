<?php

namespace App\Models;

use Database\Factories\CompanyInviteStudentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInviteStudent extends Model
{
    /** @use HasFactory<CompanyInviteStudentFactory> */
    use HasFactory;

    protected $table = 'interview_invitations';

    protected $fillable = [
        'company_profile_id',
        'student_profile_id',
        'sent',
        'invitation_date',
        'invitation_details',
        'invitation_status',
    ];

    protected $casts = [
        'sent' => 'datetime',
        'invitation_date' => 'date',
    ];

    public function companyProfile()
    {
        return $this->belongsTo(CompanyProfile::class);
    }

    public function studentProfile()
    {
        return $this->belongsTo(StudentProfile::class, 'student_profile_id');
    }

    // Avoir les status en francais directement
    public function getStatusLabel()
    {
        return match ($this->invitation_status) {
            'sent' => 'Envoyée',
            'read' => 'Lue',
            'accepted' => 'Acceptée',
            'declined' => 'Refusée',
            'interview_scheduled' => 'Entretien planifié',
            'completed' => 'Terminée',
            default => 'Inconnu'
        };
    }
}
