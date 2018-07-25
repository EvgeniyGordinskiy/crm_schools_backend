<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SocialAuthRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UsersAuthSocial;
use App\Services\Image\ImageService;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthSocialController extends Controller
{

    public function authenticate($provider, SocialAuthRequest $request)
    {
        $authUser = Socialite::driver($provider)->userFromToken($request->token);
        $user = $this->findUser($authUser);
        if(!$user) {
            $this->setStatusCode(206);
            return $this->respondWithData(['authUser' => $authUser,'status' => 206]);
        }

        $token = JWTAuth::fromSubject($user);

        return $this->respond(compact('token'));
    }

    public function findUser($authUser)
    {
        $user = User::whereEmail($authUser->email)->first();

        return $user;
    }
}
