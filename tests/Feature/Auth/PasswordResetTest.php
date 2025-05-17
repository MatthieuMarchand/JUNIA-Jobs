<?php

namespace Tests\Feature\Auth;

use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_display_form(): void
    {
        $response = $this->get("/reset-password/token");

        $response->assertOk();
    }

    public function test_can_reset_password_with_correct_data(): void
    {
        $user = User::factory()->create();

        $token = 'token';
        PasswordResetToken::factory()->create([
            'email' => $user->email,
            'token' => $token,
        ]);

        $newPassword = 'newpassword';

        $response = $this->post("/reset-password", [
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
            'token' => $token,
        ]);

        $response->assertRedirectToRoute('login');
        $response->assertSessionHas("success", "Mot de passe réinitialisé avec succès.");

        $user->refresh();
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    public function test_cannot_reset_password_with_incorrect_data(): void
    {
        $user = User::factory()->create();

        $token = 'token';
        PasswordResetToken::factory()->create([
            'email' => $user->email,
            'token' => $token,
        ]);

        $newPassword = 'newpassword';

        $response = $this->post("/reset-password", [
            'email' => 'INCORRECT' . $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
            'token' => $token,
        ]);

        $response->assertRedirectBack();
        $response->assertSessionHasErrors([
            'email' => "Les informations fournies ne sont pas valides.",
        ]);
    }
}
