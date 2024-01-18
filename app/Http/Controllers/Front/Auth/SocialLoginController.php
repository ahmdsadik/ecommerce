<?php

namespace App\Http\Controllers\Front\Auth;

use App\Enums\SocialiteProvider;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class SocialLoginController extends Controller
{
    public function redirect(SocialiteProvider $provider)
    {
        return Socialite::driver($provider->value)->redirect();
    }

    public function callback(SocialiteProvider $provider)
    {
        try {
            $providedUser = Socialite::driver($provider->value)->stateless()->user();

            $user = User::firstOrCreate([
                'email' => $providedUser->email,
                'provider' => $provider->value,
                'provider_id' => $providedUser->id,
            ], [
                'name' => $providedUser->name,
                'provider_token' => $providedUser->token,
                'password' => Str::password(16)
            ]);

            auth()->login($user, true);
        } catch (InvalidStateException $exception) {
            return to_route('login')->with('error', 'Invalid State Try again');
        } catch (\Exception $exception) {
            return to_route('login')->with('error', 'Something wrong happened try again later');
        }

        return to_route('home');
    }

}
