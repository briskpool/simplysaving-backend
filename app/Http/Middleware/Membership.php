<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Membership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        abort_if(!(auth()->user()->membership_type != 'Professional Fund' &&  auth()->user()->membership_type != 'Bespoke Trading'), 403);
        return $next($request);
    }
}
