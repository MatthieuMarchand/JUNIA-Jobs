<?php

namespace Database\Factories\Traits;

use Illuminate\Http\UploadedFile;

trait HasFakePhoto
{
    public function withPhoto(): static
    {
        return $this->state(function (array $attributes) {
            $photo = UploadedFile::fake()->image('profile.jpg');
            $path = $photo->store('photos');

            return [
                'photo_path' => $path,
            ];
        });
    }
}
