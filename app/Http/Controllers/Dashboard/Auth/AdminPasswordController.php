<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminUpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminPasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated =$request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ],
            [],
            [
                'current_password' => __('dashboard/profile/edit.password'),
                'password' => __('dashboard/profile/edit.new_password')
            ]
        );

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);


        return back()->with('msg', __('dashboard/profile/edit.edit_alert'));
    }
}
