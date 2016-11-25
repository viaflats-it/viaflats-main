<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support;
use App\Landlord;

class authLandlord
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
        if(!\Auth::check())
        {
            return \Redirect::to('index')->withErrors('You can not access to this content');
        }
        else if(!\Auth::user()->type_person == 1)
        {
            return \Redirect::to('index')->withErrors('You can not access to this content');
        }
        return $next($request);
    }
}
