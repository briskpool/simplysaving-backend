<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCheck
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
        abort_if(auth()->user()->is_admin, 403);
        if (auth()->user()->status == 'inactive') {
            Auth::logout();
            return redirect()->route('login')->withErrors(['account_locked' => 'We have suspended your account for security reasons']);
        }
        return $next($request);
    }
}
