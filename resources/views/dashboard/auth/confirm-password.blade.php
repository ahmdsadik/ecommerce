{{--<x-guest-layout>--}}
{{--    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">--}}
{{--        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}--}}
{{--    </div>--}}

{{--    <form method="POST" action="{{ route('password.confirm') }}">--}}
{{--        @csrf--}}

{{--        <!-- Password -->--}}
{{--        <div>--}}
{{--            <x-input-label for="password" :value="__('Password')" />--}}

{{--            <x-text-input id="password" class="block mt-1 w-full"--}}
{{--                            type="password"--}}
{{--                            name="password"--}}
{{--                            required autocomplete="current-password" />--}}

{{--            <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <div class="flex justify-end mt-4">--}}
{{--            <x-primary-button>--}}
{{--                {{ __('Confirm') }}--}}
{{--            </x-primary-button>--}}
{{--        </div>--}}
{{--    </form>--}}
{{--</x-guest-layout>--}}

@extends('dashboard.layouts.guest')

@section('title'){{ __('dashboard/auth/confirm-password.title') }}
@endsection

@section('content')
    <div class="authentication-wrapper authentication-basic px-4">
        <div class="authentication-inner">


            <!-- Verify Email -->
            <div class="card">
                <div class="card-body">
                    <p class="my-1">
                        {{ __('dashboard/auth/confirm-password.paragraph') }}
                    </p>

                    <form method="POST" action="{{ route('dashboard.password.confirm') }}">
                        @csrf

                        <div class="mb-3 mt-3">
                            <label for="password" class="form-label">{{ __('dashboard/auth/confirm-password.password') }}</label>
                            <input type="password"  class="form-control" id="password" name="password"
                                   value="{{ old('password') }}"
                                   autocomplete="current-password"
                                   placeholder="{{ __('dashboard/auth/confirm-password.password_placeholder') }}" autofocus>
                            <x-input-error key="password"/>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            {{ __('dashboard/auth/confirm-password.submit_button') }}
                        </button>
                    </form>
                </div>
            </div>
            <!-- /Verify Email -->
        </div>
    </div>
@endsection

