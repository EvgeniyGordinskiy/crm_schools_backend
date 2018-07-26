<?php

namespace App\Services\Verification\Handlers;

use App\Contracts\VerificationHandler;
use App\Jobs\SendVerificationEmail;
use App\Models\User;

class EmailVerificationHandler implements VerificationHandler
{

    /**
     * @param User $user
     * @param String $string
     * @return \Illuminate\Foundation\Bus\PendingDispatch
     */
    public function send(User $user, String $string)
    {
        $sessionService = app()->make('App\Services\Session\SessionService');
        $redirect = $sessionService->get('redirectPath');
        return dispatch(new SendVerificationEmail($user, $string, $redirect ? $redirect : 'auth/login'));
    }

    /**
     * Create token
     * @return string
     */
    public function createToken()
    {
        $token = sha1(time());
        return $token;
    }
}