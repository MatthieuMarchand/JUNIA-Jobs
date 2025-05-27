<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendStudentInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $companyName;
    public string $invitationDetails;
    public string $actionUrl;

    public function __construct(string $companyName, string $invitationDetails, string $actionUrl)
    {
        $this->companyName = $companyName;
        $this->invitationDetails = $invitationDetails;
        $this->actionUrl = $actionUrl;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Invitation à un entretien par {$this->companyName}")
            ->greeting("Bonjour {$notifiable->user->full_name},")
            ->line("Vous avez reçu une invitation à un entretien de la part de {$this->companyName}.")
            ->line("Détails de l'invitation :")
            ->line($this->invitationDetails)
            ->action('Voir l’invitation', $this->actionUrl);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'company_name' => $this->companyName,
            'invitation_details' => $this->invitationDetails,
            'action_url' => $this->actionUrl,
        ];
    }
}
