<?php

namespace App\Http\Middleware;

use Closure;

class photographer
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
//        if(!Photographer::where('idPerson', '=', \Auth::user()->idPerson))
//        {
//            return \Redirect::to('/');
//        }
        return $next($request);
    }
}
