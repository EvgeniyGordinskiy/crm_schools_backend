<?php

namespace App\Services\Verification\Handlers;

use App\Contracts\VerificationHandler;
use App\Jobs\SendVerificationEmail;
use App\Mail\EmailConfirmation;
use App\Models\User;
use App\Services\Session\SessionService;
use Illuminate\Support\Facades\Mail;

class EmailVerificationHandler implements VerificationHandler
{

    /**
     * @param User $user
     * @param String $string
     * @param SessionService $sessionService
     * @return \Illuminate\Foundation\Bus\PendingDispatch
     */
    public function send(User $user, String $string,  SessionService $sessionService)
    {
        $redirect = $sessionService->get('redirectPath');
        return dispatch(new SendVerificationEmail($user, $string, $redirect ? $redirect : 'auth/login'));
    }
}