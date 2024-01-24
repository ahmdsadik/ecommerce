<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiLocalizationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : app()->getLocale();
        // set laravel localization
        app()->setLocale($local);

        return $next($request);
    }
}
