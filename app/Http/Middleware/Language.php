<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Config;
use Illuminate\Http\Request;
use Session;

class Language
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
        $segment = in_array($request->locale, Config::get('translatable.locales')) ? $request->locale : 'ar';

        Config::set('translatable.locale', $segment);
        Config::set('app.locale', $segment);
        App::setLocale($segment);
        Session::put('locale', $segment);

        if( $request->locale == 'ar')
      
        return redirect('/');

       

        return $next($request);
    }
}
