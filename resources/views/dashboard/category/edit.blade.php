@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/category/edit.title') }} - {{ $category?->name }}
@endsection

@push('css')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/libs/select2/select2.css') }}"/>
@endpush



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <a class="text-muted fw-light"
               href="{{ route('dashboard.categories.index') }}">{{ __('dashboard/category/edit.breadcrumb_1') }}</a>
            /
            {{ __('dashboard/category/edit.breadcrumb_2') }}- {{ $category?->name }}
        </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">{{ __('dashboard/category/edit.card_header') }}</h5>

                    <div class="card-body">
                        <form action="{{ route('dashboard.categories.update',$category) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <a target="_blank" href="{{ $category->getFirstMediaUrl('logo') }}">
                                    <img src="{{ $category->getFirstMediaUrl('logo') }}"
                                         alt="user-avatar"
                                         class="d-block rounded" height="100" width="100" id="uploadedAvatar"/>
                                </a>
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">
                                            {{ __('dashboard/profile/edit.upload_new_photo') }}
                                        </span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" hidden
                                               onchange="loadFile(event)"
                                               name="logo"
                                               accept="image/png, image/jpeg"/>
                                    </label>
                                    <button type="button"
                                            class="btn btn-label-secondary account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">{{ __('dashboard/profile/edit.cancel') }}</span>
                                    </button>

                                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>

                                    <x-input-error key="logo"/>
                                </div>
                            </div>

                            <hr class="mt-3 mb-4">

                            <div class="mb-4 col-md-6">
                                <label for="slug"
                                       class="form-label">{{ __('dashboard/category/edit.slug') }}</label>
                                <input class="form-control" type="text" id="slug"
                                       name="slug"
                                       placeholder="{{ __('dashboard/category/edit.slug') }}"
                                       value="{{ old('slug' , $category?->slug) }}"/>
                                <x-input-error key="'slug'"/>
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
                                                           class="form-label">{{ __('dashboard/category/edit.name',['lang' => __('lang_key.with_'.$key)]) }}</label>
                                                    <input class="form-control" type="text" id="name"
                                                           name="{{$key}}[name]"
                                                           placeholder="{{ __('dashboard/category/edit.name_placeholder',['lang' => __('lang_key.with_'.$key)]) }}"
                                                           value="{{ old($key .'.name' , $category->translate($key)?->name) }}"/>
                                                    <x-input-error key="{{$key .'.name'}}"/>

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="description"
                                                           class="form-label">{{ __('dashboard/category/edit.description',['lang' => __('lang_key.with_'.$key)]) }}</label>
                                                    <textarea class="form-control" name="{{$key}}[description]"
                                                              id="description"
                                                              cols="30"
                                                              rows="5">{{ old($key .'.description',$category->translate($key)?->description) }}</textarea>

                                                    <x-input-error key="{{$key .'.description'}}"/>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="row">
                                <!-- Dark -->
                                <div class="col-md-6 ">
                                    <label for="select2Dark"
                                           class="form-label ">{{ __('dashboard/category/edit.category') }}</label>
                                    <div class="select2-dark">
                                        <select id="select2Dark" class="select2 form-select" name="parent_id">
                                            <option value>{{ __('dashboard/category/edit.no_category') }}</option>
                                            @foreach($categories as $modelCategory)
                                                <option
                                                        @selected( old('category_id',$category->parent_id) == $modelCategory->id) value="{{ $modelCategory->id }}">{{ $modelCategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-input-error key="parent_id"/>
                                </div>

                                <div class="col-md-6">
                                    <div class="fw-semibold mb-3">{{ __('dashboard/category/edit.status') }}</div>
                                    <label class="switch switch-lg">
                                        <input type="checkbox"
                                               name="status"
                                               @checked( old('status', $category->status->value ) == CategoryStatus::ACTIVE->value)
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
                            </div>

                            <div class="card-footer mt-3">
                                <button class="btn btn-primary w-100"
                                        title="{{ __('dashboard/category/edit.submit_btn') }}">{{ __('dashboard/category/edit.submit_btn') }}</button>
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

