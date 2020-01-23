<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfEmailNotVerified
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
        if (! $request->user()->verified) {
            return redirect('/threads')->with('flash', 'You must first confirm your email address.');
        }

        return $next($request);
    }
}
