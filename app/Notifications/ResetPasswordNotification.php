<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
{
    $url = 'http://localhost:3000/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->email); // عدّل الـ port حسب الـ frontend بتاعك

    return (new MailMessage)
        ->subject(Lang::get('Réinitialisation de votre mot de passe'))
        ->view('emails.reset_password', ['url' => $url]);
}
}
