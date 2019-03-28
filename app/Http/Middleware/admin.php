<?php

namespace App\Http\Middleware;

use Closure;
use Laracasts\Flash\Flash;

class admin
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
        if($request->user()->role != 'admin')
        {
            Flash::error('No tienes autorizacion a esta peticion!');
            return redirect('/home');
        }
        return $next($request);
    }
}
