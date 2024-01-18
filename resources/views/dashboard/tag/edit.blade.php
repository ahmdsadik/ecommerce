@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/tag/edit.title') }}
@endsection

@push('css')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/libs/select2/select2.css') }}"/>
@endpush



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <a class="text-muted fw-light"
               href="{{ route('dashboard.tags.index') }}">{{ __('dashboard/tag/edit.breadcrumb_1') }}</a>
            /
            {{ __('dashboard/tag/edit.breadcrumb_2') }}
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
                    <h5 class="card-header">{{ __('dashboard/tag/edit.card_header') }}</h5>

                    <div class="card-body">
                        <form action="{{ route('dashboard.tags.update',$tag) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                            <div class="col-md-6 mb-4">

                                <label for="slug"
                                       class="form-label">{{ __('dashboard/tag/edit.slug') }}</label>
                                <input class="form-control" type="text" id="slug" name="slug"
                                       value="{{ old('slug', $tag->slug) }}"
                                />
                                <x-input-error key="slug"/>

                            </div>


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


                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="name"
                                                           class="form-label">{{ __('dashboard/tag/edit.name',['lang' => __('lang_key.with_'.$key)]) }}</label>
                                                    <input class="form-control" type="text" id="name"
                                                           name="{{$key}}[name]"
                                                           placeholder="{{ __('dashboard/tag/edit.name_placeholder',['lang' => __('lang_key.with_'.$key)]) }}"
                                                           value="{{ old($key .'.name' , $tag->translate($key)?->name) }}"/>
                                                    <x-input-error key="{{ $key . '.name' }}"/>

                                                </div>
                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fw-semibold mb-3">{{ __('dashboard/tag/edit.status') }}</div>
                                <label class="switch switch-lg">
                                    <input type="checkbox"
                                           name="status"
                                           @checked( old('status', $tag->status->value ) == \StoreStatus::ACTIVE->value)
                                           class="switch-input"
                                    >
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                          <i class="bx bx-check"></i>
                                        </span>
                                        <span class="switch-off">
                                          <i class="bx bx-x"></i>
                                        </span>
                                      </span>
                                </label>
                                <x-input-error key="status"/>
                            </div>


                            <div class="card-footer mt-3">
                                <button class="btn btn-primary w-100"
                                        title="{{ __('dashboard/tag/edit.submit_btn') }}">{{ __('dashboard/tag/edit.submit_btn') }}</button>
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

