@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/admin/create.title') }}
@endsection

@push('css')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/libs/animate-css/animate.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/libs/select2/select2.css') }}"/>

@endpush



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="{{ route('dashboard.admins.index') }}">
                    {{ __('dashboard/admin/create.breadcrumb_2') }}
                </a> / </span> {{ __('dashboard/admin/create.breadcrumb_1') }}
        </h4>

        <div class="row">
            <div class="col-md-12">

                <!-- Profile Details -->
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('dashboard/admin/create.info_header') }}</h5>
                    <div class="card-body">
                        <form action="{{ route('dashboard.admins.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">{{ __('dashboard/admin/create.name') }}</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                           value="{{ old('name') }}"/>
                                    <x-input-error key="name"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="username"
                                           class="form-label">{{ __('dashboard/admin/create.username') }}</label>
                                    <input type="text" class="form-control" id="username"
                                           name="username" value="{{ old('username') }}"/>
                                    <x-input-error key="username"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email"
                                           class="form-label">{{ __('dashboard/admin/create.email') }}</label>
                                    <input class="form-control" type="text" id="email" name="email"
                                           value="{{ old('email') }}"/>
                                    <x-input-error key="email"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"
                                           for="phone">{{ __('dashboard/admin/create.phone') }}</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">EG (+20)</span>
                                        <input type="text" id="phone" name="phone"
                                               value="{{ old('phone') }}"
                                               class="form-control"/>
                                        <x-input-error key="phone"/>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="password"
                                               class="form-label">{{ __('dashboard/admin/create.password') }}</label>
                                        <input class="form-control" type="password" id="password" name="password"/>

                                        <x-input-error key="password"/>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="password_confirmation"
                                               class="form-label">{{ __('dashboard/admin/create.confirm_password') }}</label>
                                        <input class="form-control" type="password" id="password_confirmation"
                                               name="password_confirmation"/>


                                        <x-input-error key="password_confirmation"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col col-md-6 ecommerce-select2-dropdown">
                                <label for="tag_id"
                                       class="form-label">{{ __('dashboard/admin/create.role') }}</label>
                                <div class="select2-dark">
                                    <select id="tag_id" class="select2 form-select" multiple name="role_id[]">
                                        @foreach($roles as $role)
                                            <option
                                                    @selected( in_array( $role->id, old('role_id') ?? [] ) ) value="{{ $role->id }}">{{ $role->display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error key="tag_id"/>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                        class="btn btn-primary me-2">{{ __('dashboard/admin/create.save_info_button') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Profile Details -->
            </div>
        </div>
    </div>

    @include('dashboard.partials.toast')

@endsection

@push('js')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/dashboard/vendor/libs/select2/select2.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('assets/dashboard/js/forms-selects.js') }}"></script>

@endpush
