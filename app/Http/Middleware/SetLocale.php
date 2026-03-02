<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected array $supported = ['tr', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale');
        if (!$locale) {
            $locale = $request->cookie('locale');
        }
        if (!in_array($locale, $this->supported, true)) {
            $locale = config('app.locale', 'tr');
        }
        app()->setLocale($locale);
        return $next($request);
    }
}

