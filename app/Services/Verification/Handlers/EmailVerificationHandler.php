<?php
namespace App\Services\Verification\Handlers;

use App\Contracts\VerificationHandler;
use App\Jobs\SendVerificationEmail;
use App\Models\EmailConfirmations;
use App\Models\User;

class EmailVerificationHandler implements VerificationHandler
{

    /**
     * @param User $user
     * @param String $string
     * @param String $redirectPath
     * @return \Illuminate\Foundation\Bus\PendingDispatch
     */
    public function send(User $user, String $string, $redirectPath)
    {
        if (!$redirectPath) return false;
        return dispatch(new SendVerificationEmail($user, $string, $redirectPath));
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
    
    public function confirm(User &$user)
    {
        EmailConfirmations::whereUserId($user->id)->delete();
        (new EmailConfirmations(['user_id' => $user->id]))->save();
        $user->update(['emailVerified   ' => 1]);
    }
}