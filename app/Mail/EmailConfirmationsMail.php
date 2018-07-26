<?php

namespace App\Mail;

use App\Models\User;
use App\Services\Session\SessionService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailConfirmationsMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $token;
    private $redirectPath;

    /**
     * EmailConfirmation constructor.
     * @param User $user
     * @param string $token
     */
    public function __construct(User $user, String $token, $redirectPath)
    {
        $this->user = $user;
        $this->token = $token;
        $this->redirectPath = $redirectPath;
    }

    /**
     * @return $this
     */
    public function build()
    {
            $url = env('APP_FRONT_URL').$this->redirectPath.'?token='.$this->token;
            return $this
                ->to($this->user->email)
                ->markdown('emails.confirmation')
                ->with(['url' => $url]);
    }
}
