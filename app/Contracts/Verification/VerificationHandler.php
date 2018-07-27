<?php

namespace App\Contracts;

use App\Models\User;
use App\Services\Session\SessionService;

interface VerificationHandler
{
    /**
     * @param User $user
     * @param String $string
     * @param $params
     * @return mixed
     */
    public function send(User $user, String $string, $params) ;

    /**
     * Create token
     * @return string
     */
    public function createToken();

    /**
     * Confirm user
     * @param User $user
     * @return mixed
     */
    public function confirm(User &$user);
}