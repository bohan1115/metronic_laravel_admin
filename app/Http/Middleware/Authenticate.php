<?php

namespace App\Http\Middleware;

use App\Http\Utils;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class Authenticate
{
    use Utils;
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Session::get('user',null);
        if(!$user) {
            if ($request->getRequestUri() == '/account/login' || $request->getRequestUri() == '/account/loginAjax') {
                return $next($request);
            } else {

                return redirect()->route('login');
            }
        }
        return $next($request);
    }
}
