<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class CheckApiKeyMiddleware
{
    use ApiResponse;

    public function handle(Request $request, Closure $next)
    {
        if ( !$request->hasHeader('x-api-key') && (getenv('API_KEY') !== $request->header('x-api-key'))) {
            return $this->errorResponse('Wrong Api key');
        }
        return $next($request);
    }
}
