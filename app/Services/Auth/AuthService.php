<?php

namespace App\Services\Auth;

use App\Models\Role;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    /**
     *  Authenticate user
     * @param $email string
     * @param $password string
     * @param $expiresTime string
     * @return mixed
     */
    public function authenticate($email, $password, $expiresTime)
    {
       $token = JWTAuth::attempt(['email' => $email, 'password' => $password], ['exp' => $expiresTime]);

       return $token;
    }

    /**
     * Authenticate user by users id. 
     * @param $user
     * @return mixed
     */
    public function authenticateById(User $user)
    {
        $token = JWTAuth::fromSubject($user);
        return $token;
    }

    /**
     * Register user
     * @param $name
     * @param $email
     * @param $password
     * @return mixed
     */
    public function register($name, $email, $password, $role_name, $phone)
    {
        $roleId = Role::whereName($role_name)->first();
        $user = new User(
            [
                'name'      => $name,
                'email'     => $email,
                'phone'     => $phone,
                'password'  => $password,
                'role_id'   => $roleId->id,
            ]
        );
        $user->password = bcrypt($user->password);
//        $user->token = str_random(30);

        $user->save();

        $credentials = ['email' => $email, 'password' => $password];

        $token = JWTAuth::attempt($credentials);

        return ['token' => $token, 'user' => $user];
    }

}