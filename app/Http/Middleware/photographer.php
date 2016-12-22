<?php

namespace App\Http\Middleware;

use Closure;

class photographer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\Auth::check()) {
            return \Redirect::to('index')->withErrors('You can not access to this content');
        } else if (!\Auth::user()->type_person == 2) {
            return \Redirect::to('index')->withErrors('You can not access to this content');
        }
        return $next($request);
    }
}
