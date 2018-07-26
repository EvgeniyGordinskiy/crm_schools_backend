<?php

namespace App\Contracts;

use App\Models\User;
use App\Services\Session\SessionService;

interface VerificationHandler
{
    /**
     * @param User $user
     * @param String $string
     * @param SessionService $sessionService
     * @return mixed
     */
    public function send(User $user, String $string, SessionService $sessionService) ;
}