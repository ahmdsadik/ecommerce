@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/tag/create.title') }}
@endsection

@push('css')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/libs/select2/select2.css') }}"/>
@endpush



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <a class="text-muted fw-light"
               href="{{ route('dashboard.tags.index') }}">{{ __('dashboard/tag/create.breadcrumb_1') }}</a>
            /
            {{ __('dashboard/tag/create.breadcrumb_2') }}
        </h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">{{ __('dashboard/tag/create.card_header') }}</h5>

                    <div class="card-body">
                        <form action="{{ route('dashboard.tags.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="nav-align-top  shadow-none">
                                <ul class="nav nav-tabs shadow-none" role="tablist">

                                    @foreach(LaravelLocalization::getLocalesOrder() as $key =>  $locale)
                                        <li class="nav-item shadow-none">
                                            <button type="button"
                                                    @class([
                                                            'nav-link',
                                                            'active' => $key == app()->getLocale(),
                                                             ])
                                                    role="tab"
                                                    data-bs-toggle="tab" data-bs-target="#{{ $locale['name'] }}"
                                                    aria-controls="{{ $locale['name'] }}"
                                                    aria-selected="{{ $key == app()->getLocale() }}">{{ __('lang_key.'.$key) }}
                                            </button>
                                        </li>
                                    @endforeach


                                </ul>
                                <div class="tab-content shadow-none">
                                    @foreach(LaravelLocalization::getLocalesOrder() as $key =>  $locale)
                                        <div
                                            @class([
                                                           'show fade tab-pane shadow-none',
                                                           'active' => $key == app()->getLocale(),
                                                            ])
                                            id="{{ $locale['name'] }}"
                                            role="tabpanel">


                                            <div class="col-md-6">

                                                <label for="name"
                                                       class="form-label">{{ __('dashboard/tag/create.name',['lang' => __('lang_key.with_'.$key)]) }}</label>
                                                <input class="form-control" type="text" id="name" name="{{$key}}[name]"
                                                       placeholder="{{ __('dashboard/tag/create.name_placeholder',['lang' => __('lang_key.with_'.$key)]) }}"
                                                       value="{{ old($key.'.name') }}"/>
                                                <x-input-error key="{{$key .'.name'}}"/>

                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>


                            <div class="card-footer mt-3">
                                <button class="btn btn-primary w-100"
                                        title="{{ __('dashboard/tag/create.submit_btn') }}">{{ __('dashboard/tag/create.submit_btn') }}</button>
                            </div>


                        </form>
                    </div>
                </div>
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

