<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/password/reset/' . $this->token . '?email=' . $notifiable->getEmailForPasswordReset());

        return (new MailMessage)
            ->subject('Reset Password - MaztechGarage')
            ->greeting('Halo ' . $notifiable->nama . '!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.')
            ->action('Reset Password', $url)
            ->line('Tautan reset password ini akan kadaluwarsa dalam 60 menit.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.')
            ->salutation('Tim MaztechGarage');
    }
}
