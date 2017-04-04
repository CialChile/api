<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

class UserSuperAdmin
{
    /**
     * @var ResponseFactory
     */
    private $response;
    /**
     * @var JWTAuth
     */
    private $JWTAuth;

    public function __construct(ResponseFactory $response, JWTAuth $JWTAuth)
    {

        $this->response = $response;
        $this->JWTAuth = $JWTAuth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::user()->isSuperUser()) {
            $this->JWTAuth->invalidate($this->JWTAuth->getToken());
            return $this->response->json(['message' => 'No tienes permisos para acceder suficientes'], 401);
        }

        return $next($request);
    }
}
