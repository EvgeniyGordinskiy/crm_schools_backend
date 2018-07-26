<?php
namespace App\Http\Controllers;

use App\Http\Requests\Verify\VerifyEmail;
use App\Models\User;
use App\Services\Session\SessionService;
use App\Services\Verification\VerificationService;

class VerifyController extends Controller
{
    public function verifyEmail(VerifyEmail $request, SessionService $sessionService)
    {
        $user = User::whereEmail($request->email)->first();
        if($user) {
            $status = VerificationService::send($user);
            if( $status === VerificationService::SUCCESSFULLY_SEND ) {
                $sessionService->set('redirectPath', $request->redirectPath);
                return $this->respondWithSuccess('Email successfully sent');
            }
        }
        return $this->respondWithError('User with this email is not found.', 403);
    }
}