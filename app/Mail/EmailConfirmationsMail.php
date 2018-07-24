<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailConfirmationsMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $token;

    /**
     * EmailConfirmation constructor.
     * @param User $user
     * @param string $token
     */
    public function __construct(User $user, String $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = env('APP_FRONT_URL').'auth/resetPassword?token='.$this->token;
        return $this
            ->to($this->user->email)
            ->markdown('emails.confirmation')
            ->with(['url' => $url]);
    }
}
