<?php
namespace App\Services\Verification\Handlers;

use App\Contracts\VerificationHandler;
use App\Models\User;
use App\Services\Sms\SmsService;


class SmsVerificationHandler implements VerificationHandler
{
    public function send(User $user, String $string)
    {
        $smsService = app('App\Services\Sms\SmsService');
        $status =  $smsService->send($string, $user->phone);
        return $smsService::SMS_SENT === $status;
    }

    public function createToken()
    {
        return 123456;
    }
}