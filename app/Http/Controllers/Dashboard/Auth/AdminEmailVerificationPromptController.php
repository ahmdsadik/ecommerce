<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminEmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {


        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::DASHBOARD)
                    : view('dashboard.auth.verify-email');
    }
}
