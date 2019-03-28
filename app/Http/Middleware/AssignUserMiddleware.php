<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AssignUserMiddleware
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
        if(!Auth::user()->isDirector())
        {
            if(Auth::user()->isAdmin())
            {
                return $next($request);
            }
            abort(403);
        }
        return $next($request);
    }
}
