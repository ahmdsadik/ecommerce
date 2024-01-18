<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureAdminEmailIsVerifiedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
//        dd($request->user());
        if (! $request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
                ! $request->user()->hasVerifiedEmail())) {
            return $request->expectsJson()
                ?
                : to_route('dashboard.verification.notice');
        }

        return $next($request);
    }
}
