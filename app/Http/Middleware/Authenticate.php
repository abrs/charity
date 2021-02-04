<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! Auth::user()) {
            throw new AuthorizationException();
        }
        
        // if (! $request->expectsJson()) {
            // return route('login', ['tenant' => tenant('id')]);
        // }
    }
}
