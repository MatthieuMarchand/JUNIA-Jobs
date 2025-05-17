<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;
use function route;

class PasswordResetRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_display_form(): void
    {
        $response = $this->get('/reset-password/request');

        $response->assertOk();
    }

    public function test_submit_send_email_to_user_if_exists(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->post('/reset-password/request', [
            'email' => $user->email,
        ]);

        $response->assertRedirectBack();
        $response->assertSessionHas('success', "Un mail a été envoyé à $user->email si un compte utilisateur existe avec cette adresse.");

        Notification::assertSentTo([$user], ResetPasswordNotification::class, function ($notification) use ($user) {
            $mailData = $notification->toMail($user)->toArray();

            $token = "RANDOM_TOKEN";
            $fakeRoute = route('password-reset.create', ['token' => $token]);
            $routeStart = Str::before($fakeRoute, $token);

            return Str::startsWith($mailData["actionUrl"], $routeStart);
        });
    }

    public function test_submit_do_not_send_email_but_display_it_has_been_sent_if_user_dont_exists(): void
    {
        Notification::fake();

        $email = 'nobody@example.com';
        $response = $this->post('/reset-password/request', [
            'email' => $email,
        ]);

        $response->assertRedirectBack();
        $response->assertSessionHas('success', "Un mail a été envoyé à $email si un compte utilisateur existe avec cette adresse.");

        Notification::assertNothingSent();
    }
}
