<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verification_url;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->verification_url = route('user.verify', $user->verification_token);
    }

    public function build()
    {
        return $this->view('emails.registration');
    }
}
