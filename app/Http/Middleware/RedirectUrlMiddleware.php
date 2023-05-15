<?php

namespace App\Http\Middleware;

use App\Enums\RedirectUrlEnum;
use Closure;
use Modules\Redirection\Models\Redirection;

class RedirectUrlMiddleware
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
        if ( $redirection = Redirection::where('from', 'like', trim(urldecode(request()->path()), '/') )->first() )
            return redirect($redirection->to, $redirection->code);

        return $next($request);
    }
}
