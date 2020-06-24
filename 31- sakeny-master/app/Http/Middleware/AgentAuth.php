<?php
namespace App\Http\Middleware;

use Closure;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AgentAuth
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
        if (auth()->guard('user')->check() && auth()->guard('user')->user()->activation == 1 && auth()->guard('user')->user()->type == 3) {
            return $next($request);
        }
        return redirect(LaravelLocalization::getURLFromRouteNameTranslated( app()->getLocale() , 'routes.user_login'));
    }
}