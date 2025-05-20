<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;
use function is_null;
use function now;

trait HasPhoto
{
    public function temporaryPhotoUrl(): string|null
    {
        if (is_null($this->photo_path)) {
            return null;
        }

        return Storage::temporaryUrl($this->photo_path, now()->addMinute());
    }
}
