<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Utils\RouteGuesser;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use function resolve;

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

        $routeGuesser = resolve(RouteGuesser::class);

        Notification::assertSentTo([$user], ResetPasswordNotification::class,
            function (ResetPasswordNotification $notification) use ($user, $routeGuesser) {
                $actionUrl = $notification->toMail($user)->actionUrl;

                return $routeGuesser->fromUrl($actionUrl)->getName() === 'password-reset.create';
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
