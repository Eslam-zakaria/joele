<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Config;
use Illuminate\Http\Request;
use Session;

class EnforceLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->segment(1) ===  'super'){
            app()->setLocale('en');
            config(['translatable.locale'=> 'en']);
            config(['app.locale'=> 'en']);
        }
        return $next($request);
    }
}
