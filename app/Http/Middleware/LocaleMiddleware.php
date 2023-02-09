<?php

namespace App\Http\Middleware;

use Closure;
use App;

class LocaleMiddleware
{
	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        App::setLocale(\Route::current()->parameter('locale'));


        return $next($request);
    }
}
