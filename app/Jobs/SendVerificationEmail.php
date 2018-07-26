<?php

namespace App\Jobs;

use App\Mail\EmailConfirmationsMail;
use App\Models\User;
use App\Services\Session\SessionService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $user;
    protected $token;
    protected $redirectPath;

    /**
     * SendVerificationEmail constructor.
     * @param User $user
     * @param String $string
     * @param $redirectPath
     */
    public function __construct(User $user, String $string, String $redirectPath)
    {
        $this->user = $user;
        $this->token = $string;
        $this->redirectPath = $redirectPath;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new EmailConfirmationsMail($this->user, $this->token, $this->redirectPath));
    }
}
