<?php

namespace App\Models;

use Database\Factories\CompanyProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyProfile extends Model
{
    /** @use HasFactory<CompanyProfileFactory> */
    use HasFactory;

    use Traits\HasPhoto;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'photo_path',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function CompanyInviteStudent(){
        return $this->belongsToMany(CompanyInviteStudent::class);
    }

}
