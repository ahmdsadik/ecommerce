<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveEmptyValueOrNullMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Remove keys with empty values
        $newDataForRequest = array_filter($request->except('_token'), function ($value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    return !is_null($v) && $v !== '';
                }
            }
            return !is_null($value) && $value !== '';
        });

        // Replace the original request data
        $request->replace($newDataForRequest);

        return $next($request);
    }
}
