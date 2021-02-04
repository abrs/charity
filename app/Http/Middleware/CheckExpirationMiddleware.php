<?php

namespace App\Http\Middleware;

use App\Exceptions\TokenExpiredException;
use Carbon\Carbon;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class CheckExpirationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::user()->token()->expires_at->gt(Carbon::now())){
            
            #delete the expired token
            Auth::user()->token()->delete();
            #throw token is expired exception
            throw new TokenExpiredException();
        }

        return $next($request);
    }
}
