<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends VerifyEmailBase
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('تفعيل الإيميل')
            ->line('الرجاء الضغط على الزر أدناه لتفعيل الإيميل.')
            ->action('تفعيل الإيميل', $verificationUrl)
            ->line('إذا لم تقم بإنشاء حساب، يمكنك تجاهل هذا الإيميل.');
    }
}
