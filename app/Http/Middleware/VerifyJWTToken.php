<?php
namespace App\Http\Middleware;

use App\Traits\Restable;
use Closure;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

class VerifyJWTToken extends Authenticate
{
    use Restable;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $result = parent::handle($request, $next);
        $token = $this->auth->setRequest($request)->getToken();
        $user = $this->auth->authenticate($token);

        if (!$user) {
            return $this->respondUnauthorized(
                'Email not verified',
                40113
            );
        }

        return $result;
    }
}