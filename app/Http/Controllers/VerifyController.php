<?php
namespace App\Http\Controllers;

use App\Http\Requests\Verify\VerifyEmail;
use App\Http\Requests\Verify\VerifySms;
use App\Models\User;
use App\Services\Verification\Handlers\EmailVerificationHandler;
use App\Services\Verification\Handlers\SmsVerificationHandler;
use App\Services\Verification\VerificationService;

class VerifyController extends Controller
{
    public function verifyEmail(VerifyEmail $request, EmailVerificationHandler $handler)
    {
        $user = User::whereEmail($request->email)->first();
        if($user) {
            $status = VerificationService::send($user, $handler,$request->redirectPath);
            if( $status === VerificationService::SUCCESSFULLY_SEND ) {
                return $this->respondWithSuccess('Email successfully sent');
            }
        }
        return $this->respondWithError('User with this email is not found.', 403);
    }

    public function verifyPhone(VerifySms $request, SmsVerificationHandler $handler)
    {
        $user = User::whereEmail($request->email)->first();
        if($user) {
            $status = VerificationService::send($user, $handler);

            if( $status === VerificationService::SUCCESSFULLY_SEND ) {
                return $this->respondWithSuccess('Sms successfully sent');
            }
            return $this->respondWithError('Sms was not sent');
        }
        return $this->respondWithError('User is not found.', 403);
    }
}