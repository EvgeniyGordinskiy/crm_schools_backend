<?php

namespace App\Services\Verification;

use App\Contracts\VerificationHandler;
use App\Models\User;
use App\Models\UsersVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class VerificationService
{
    /**
     * Life time token
     * @var int
     */
    private static $expiration_time = 5;

    /**
     * Default verification handler
     * @var string
     */
    private static $defaultHandler = 'App\Services\Verification\Handlers\EmailVerificationHandler';

    /**
     * Current verification handler
     * @var null
     */
    private static $currentHandler = null;

    /**
     * Class which called Verification Service
     * @var string
     */
    private static $calledClass = '';

    /**
     * @var string
     */
    private static $playload = '';

    /**
     *  Statuses of the service
     */
    const SUCCESSFULLY_SEND = 1;
    const ERROR_WHILE_SEND = 0;

    public static function send(User $user, VerificationHandler $handler = null)
    {
        self::$calledClass = get_called_class();
        self::$currentHandler = $handler ?? new self::$defaultHandler();
        $token = self::$currentHandler->createToken();

        if(self::saveNewVerification($token, $user) && self::$currentHandler->send($user, $token)) {
            return self::SUCCESSFULLY_SEND;
        }

        return self::ERROR_WHILE_SEND;
    }

    /**
     * Check token
     * @param $token
     * @return user.id or false.
     */
    public static function checkToken($token)
    {
        if (Cache::has($token)) {
            $verification = UsersVerification::whereUserId(Cache::get($token))->first();
            if($verification->user) return $verification->user;
        }
        return false;
    }

    public static function setPlayload( Array $playload)
    {
        self::$playload = json_encode($playload);
    }

    /**
     * @param String $token
     * @param User $user
     * @return bool
     */
    private static function saveNewVerification(String $token, User $user)
    {
        $expiresAt = Carbon::now()
            ->addMinutes(self::$expiration_time);
        Cache::put($token, $user->id, $expiresAt);
        UsersVerification::whereUserId($user->id)->whereClassName(self::$calledClass)->delete();
        $verification = new UsersVerification([
            'user_id'    => $user->id,
            'token'      => $token,
            'class_name' => self::$calledClass,
            'playload'   => self::$playload,
        ]);
       return (boolean) $verification->save();
    }
}