<?php

namespace Database\Factories;

use App\Models\PasswordResetToken;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<PasswordResetToken>
 */
class PasswordResetTokenFactory extends Factory
{
    /**
     * The current token being used by the factory.
     */
    protected static ?string $token;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'token' => static::$token ??= Hash::make('token'),
        ];
    }
}
