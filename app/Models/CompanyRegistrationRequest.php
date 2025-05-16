<?php

namespace App\Models;

use Database\Factories\CompanyRegistrationRequestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyRegistrationRequest extends Model
{
    /** @use HasFactory<CompanyRegistrationRequestFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'company_name',
        'message',
        'approved',
    ];

    protected function casts(): array
    {
        return [
            'approved' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
