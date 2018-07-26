<?php

namespace App\Contracts;

use App\Models\User;
use App\Services\Session\SessionService;

interface VerificationHandler
{
    /**
     * @param User $user
     * @param String $string
     * @return mixed
     */
    public function send(User $user, String $string) ;

    /**
     * Create token
     * @return string
     */
    public function createToken();
}