<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Available locales
     */
    protected $locales = ['fr', 'en', 'ar'];

    /**
     * Default locale
     */
    protected $defaultLocale = 'fr';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priority 1: URL parameter (for language switcher)
        if ($request->has('lang') && in_array($request->get('lang'), $this->locales)) {
            $locale = $request->get('lang');
            Session::put('locale', $locale);
        }
        // Priority 2: Session
        elseif (Session::has('locale') && in_array(Session::get('locale'), $this->locales)) {
            $locale = Session::get('locale');
        }
        // Priority 3: Browser language
        elseif ($request->header('Accept-Language')) {
            $browserLang = substr($request->header('Accept-Language'), 0, 2);
            $locale = in_array($browserLang, $this->locales) ? $browserLang : $this->defaultLocale;
            Session::put('locale', $locale);
        }
        // Priority 4: Default
        else {
            $locale = $this->defaultLocale;
            Session::put('locale', $locale);
        }

        App::setLocale($locale);

        return $next($request);
    }
}

