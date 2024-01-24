<?php

namespace App\Http\Middleware;

use App\Enums\AdminStatus;
use Closure;
use Illuminate\Http\Request;

class CheckAdminStatusMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth('admin')->user()->status === AdminStatus::INACTIVE) {
            auth('admin')->logout();

            return redirect()->route('dashboard.login')
                ->withErrors(['check' => __('validation.account_disabled')]);
        }
        return $next($request);
    }
}
