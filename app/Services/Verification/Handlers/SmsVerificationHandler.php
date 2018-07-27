<?php
namespace App\Services\Verification\Handlers;

use App\Contracts\VerificationHandler;
use App\Models\SmsConfirmations;
use App\Models\User;
use App\Services\Sms\SmsService;


class SmsVerificationHandler implements VerificationHandler
{
    public function send(User $user, String $string, $params = false)
    {
        $smsService = app('App\Services\Sms\SmsService');
        $status =  $smsService->send($string, $user->phone);
        
        return $smsService::SMS_SENT === $status;
    }

    public function createToken()
    {
        return mt_rand(100000, 999999);
    }

    public function confirm(User &$user)
    {
        SmsConfirmations::whereUserId($user->id)->delete();
        (new SmsConfirmations(['user_id' => $user->id]))->save();
        $user->update(['phoneNumberVerified' => 1]);
    }
}