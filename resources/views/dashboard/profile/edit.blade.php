@extends('dashboard.layouts.app')

@section('title'){{ __('dashboard/profile/edit.title') }}
@endsection

@push('css')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/libs/animate-css/animate.css') }}"/>
@endpush



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light"> {{ __('dashboard/profile/edit.breadcrumb_2') }} / </span>  {{ __('dashboard/profile/edit.breadcrumb_1') }}
        </h4>

        <div class="row">
            <div class="col-md-12">

                <!-- Profile Details -->
                <div class="card mb-4">
                    @include('dashboard.profile.partials.update-profile-information-form')
                </div>
                <!-- /Profile Details -->

                <!-- Update Password -->
                <div class="card mb-4">
                    @include('dashboard.profile.partials.update-password-form')
                </div>
                <!-- /Update Password -->


                <!-- Delete Account -->
                <div class="card">
                    @include('dashboard.profile.partials.delete-user-form')
                </div>
                <!-- /Delete Account -->
            </div>
        </div>
    </div>

    @include('dashboard.partials.toast')

@endsection

@push('js')

    <script src="{{ asset('assets/dashboard/vendor/libs/i18n/i18n.js') }}"></script>

    <!-- For Image Change -->

    <script>
        var loadFile = function (event) {
            var output = document.getElementById('uploadedAvatar');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>

@endpush

