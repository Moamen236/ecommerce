<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LocalizationMiddleware
{

    protected function storeCookie($name, $value)
    {
        $minutes = 60 * 24 * 30;
        Cookie::queue($name, $value, $minutes);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check('admin')) {
            if (auth()->user()->settings) {
                app()->setLocale(auth()->user()->settings->language);
            } else {
                if (in_array($request->locale, ['en', 'ar'])) {
                    app()->setLocale($request->locale);
                } else {
                    $name = 'lang';
                    if (Cookie::get($name) && in_array(Cookie::get($name), ['en', 'ar'])) {
                        app()->setLocale(Cookie::get($name));
                    } else {
                        $this->storeCookie($name, app()->getLocale());
                    }
                }
            }
        } else {
            $name = 'lang';
            if ($request->locale && in_array($request->locale, ['en', 'ar'])) {
                if ($request->locale != Cookie::get($name)) {
                    $this->storeCookie($name, $request->locale);
                }
                app()->setLocale($request->locale);
            } else {
                if (Cookie::get($name) && in_array(Cookie::get($name), ['en', 'ar'])) {
                    app()->setLocale(Cookie::get($name));
                } else {
                    $this->storeCookie($name, app()->getLocale());
                }
            }
        }
        \URL::defaults(['locale' => app()->getLocale()]);
        return $next($request);
    }
}
