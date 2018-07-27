<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\UserResource;
use App\Models\EmailConfirmations;
use App\Models\UsersAuthSocial;
use App\Services\Image\ImageService;
use App\Services\Verification\VerificationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\CheckResetTokenRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\AuthenticateRequest;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    /**
     * This action will be fired when the user tries to authenticate.
     *
     * @param AuthenticateRequest $request
     * @param AuthService $authService
     * @uses
     *  POST auth/
     *              {
     *              email: string, valid email of the user,
     *              password: string, password of thr user
     *              }
     *
     * @return \Illuminate\Http\JsonResponse
     *   Response body
     *     {
     *       token: $token
     *     }
     */
    public function authenticate(AuthenticateRequest $request, AuthService $authService)
    {
        $expiresTime = Carbon::now()->addHour(1)->timestamp;
        if($request->has('rememberMe') && $request->get('rememberMe')) {
            $expiresTime = Carbon::now()->addDays(7)->timestamp;
        }
        $token = $authService->authenticate($request->email, $request->password, $expiresTime);
        if (!$token) {
            return $this->respondUnauthorized('Invalid credentials', 401);
        }
        return $this->respondWithData(['token' => $token]);
    }

    /**
     * The action to register a user.
     *
     * @param RegisterRequest $request The incoming request with data.
     * @param AuthService $authService
     * @uses
     *  auth/register
     *             {
     *              first_name: string, required, first name of the user,
     *              last_name: string, required, last name of the user,
     *              timeZone: string, required, current users time Zone,
     *              email: string, required, valid suers email,
     *              password: string, required, users password.
     *              confirm_password: string, required.
     *             }
     *
     * @return JsonResponse The JSON response if the user was registered.
     *   Response body
     *     {
     *       token: $token
     *     }
     */
    public function register(RegisterRequest $request,  AuthService $authService, ImageService $imageService)
    {
      

        $resp = $authService->register($request->name, $request->email, $request->password, $request->role_name, $request->phone);

        if ( !$resp['token'] || !$resp['user']) {
            return $this->respondUnauthorized('Error while registered user', 403);
        }

        if($request->has('fromSocial')) {
            $nameAvatar = str_replace(' ', '',$request->name).'Avatar';
            if($request->avatar) $imageService->createImageFromPath($request->avatar, 'avatars', $nameAvatar);
            UsersAuthSocial::make([
                'user_id' => $resp['user']->id,
                'provider_name' => $request->fromSocial['provider_name'],
                'provider_id' =>  $request->fromSocial['provider_id'],
            ]);
            $resp['user']->update(['avatar' => $imageService->name]);
        }

        return $this->respondWithData(['token' => $resp['token']]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        if($user) {
            $status = VerificationService::send($user, $request->redirectPath);
            if( $status === VerificationService::SUCCESSFULLY_SEND ) {
                return $this->respondWithSuccess('Email successfully sent');
            }
        }

        return $this->respondWithError('User with this email is not found.', 403);

    }

    public function check_reset_token(CheckResetTokenRequest $request, AuthService $authService) {
        if($user = VerificationService::checkToken($request->token)) {
            $token = $authService->authenticateById($user);
             return $this->respondWithData(['token' => $token ,'authUser' =>  ['data' =>new UserResource($user)]]);
        }
        return $this->respondWithError('Token is expired', 422);
    }
    
    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = Request::user();
        if($user->update(['password' => bcrypt($request->password)])) return $this->respondWithSuccess('Password successfully changed');
        return $this->respondWithError('Something wrong is happened', 500);

    }
}
