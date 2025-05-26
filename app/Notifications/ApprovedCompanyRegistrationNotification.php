<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function route;

class ApprovedCompanyRegistrationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly string $token,
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Votre demande d'inscription a été approuvée")
            ->greeting("Bonjour {$notifiable->companyRegistrationRequest?->company_name},")
            ->line('Votre demande d\'inscription a été approuvée.')
            ->line("Créez votre mot de passe via le lien ci-dessous:")
            ->action('Créer mon mot de passe', route('password-reset.create', ['token' => $this->token, 'email' => $notifiable->email]))
            ->line('Merci pour votre partenariat !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
