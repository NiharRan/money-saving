<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
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
        if (request('lang')) {
          session()->put('language', request('lang'));
          $language = request('lang');
        } elseif (session('language')) {
          $language = session('language');
        } elseif (config('app.locale')) {
          $language = config('app.locale');
        }

        if (isset($language) && config('app.languages.' . $language)) {
          app()->setLocale($language);
        }

        return $next($request);
    }
}
