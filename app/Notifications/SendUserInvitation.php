<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class SendUserInvitation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $registrationLink = url(config('app.url') . "/register?token=" . $notifiable->token . "&email=" . $notifiable->email);

        return (new MailMessage)
            ->subject(Lang::get('Registration'))
            ->greeting(Lang::get('Hi, :email.', ['email' => $notifiable->email]))
            ->line(Lang::get('You have been invited to join :appname', ['appname' => config('app.name')]))
            ->line(Lang::get('To accept this invitation click the link below:'))
            ->action(Lang::get('Register'), url($registrationLink))
            ->line(Lang::get("The invitation only valid until :valid, please register before the invitation expired.", ['valid' => $notifiable->expired_at->format('d F Y')]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
