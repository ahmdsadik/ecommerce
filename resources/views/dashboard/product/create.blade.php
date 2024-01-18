@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/product/create.title') }}
@endsection

@push('css')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/libs/select2/select2.css') }}"/>

    <style>

        [x-cloak] {
            display: none !important;
        }

        #container {
            width: 1000px;
            margin: 20px auto;

        }

        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 200px;
        }

        .ck-content .image {
            /* block images */
            max-width: 80%;
            margin: 20px auto;
        }
    </style>

@endpush



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <a class="text-muted fw-light"
               href="{{ route('dashboard.products.index') }}">{{ __('dashboard/product/create.breadcrumb_1') }}</a>
            /
            {{ __('dashboard/product/create.breadcrumb_2') }}
        </h4>

        <form action="{{ route('dashboard.products.store') }}" method="post"
              enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-12">

                    <div class="card mb-4">
                        <h5 class="card-header">{{ __('dashboard/product/create.logo') }}</h5>

                        <div class="card-body">


                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ asset('assets/dashboard/default/category/categories.png') }}"
                                     alt="user-avatar"
                                     class="d-block rounded" height="100" width="100" id="uploadedAvatar"/>
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- First column-->
                <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">{{ __('dashboard/product/edit.product_info') }}</h5>
                        </div>
                        <div class="card-body">
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
                                <div class="tab-content p-0 shadow-none">
                                    @foreach(LaravelLocalization::getLocalesOrder() as $key =>  $locale)
                                        <div
                                            @class([
                                                           'show fade tab-pane shadow-none',
                                                           'active' => $key == app()->getLocale(),
                                                            ])
                                            id="{{ $locale['name'] }}"
                                            role="tabpanel">


                                            <div class="row">
                                                <div class="my-3">
                                                    <label for="name"
                                                           class="form-label">{{ __('dashboard/product/create.name',['lang' => __('lang_key.with_'.$key)]) }}</label>
                                                    <input class="form-control" type="text" id="name"
                                                           name="{{$key}}[name]"
                                                           placeholder="{{ __('dashboard/product/create.name_placeholder',['lang' => __('lang_key.with_'.$key)]) }}"
                                                           value="{{ old($key.'.name') }}"/>
                                                    <x-input-error key="{{$key .'.name'}}"/>
                                                </div>


                                                <div class="">
                                                    <label for="description"
                                                           class="form-label">{{ __('dashboard/product/create.description',['lang' => __('lang_key.with_'.$key)]) }}</label>
                                                    <textarea class="form-control" name="{{$key}}[description]"
                                                              id="editor"
                                                              cols="30"
                                                              rows="8">{{ old($key .'.description') }}</textarea>

                                                    <x-input-error key="{{$key .'.description'}}"/>
                                                </div>

                                                <div class="mt-3">
                                                    <label for="short_description"
                                                           class="form-label">{{ __('dashboard/product/create.short_description',['lang' => __('lang_key.with_'.$key)]) }}</label>
                                                    <textarea class="form-control"
                                                              name="{{$key}}[short_description]"
                                                              id="short_description"
                                                              cols="30"
                                                              rows="5">{{ old($key .'.short_description') }}</textarea>

                                                    <x-input-error key="{{$key .'.short_description'}}"/>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /Product Information -->

                </div>
                <!-- /First column -->

                <!-- Second column -->
                <div class="col-12 col-lg-4">
                    <!-- Pricing Card -->
                    <div x-data="{ price:'{{ old('price') }}',compare_price: '{{ old('compare_price') }}' }"
                        class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('dashboard/product/edit.product_price') }}</h5>
                        </div>
                        <div
                            class="card-body">
                            <!-- Base Price -->
                            <div class="mb-3">
                                <label for="price"
                                       class="form-label">{{ __('dashboard/product/create.price') }}</label>
                                <input class="form-control" type="text" id="price"
                                       name="price"
                                       x-model="price"
                                />
                                <x-input-error key="price"/>

                                <div class="mt-1 text-danger" x-cloak x-transition
                                     x-show="parseFloat(price) > parseFloat(compare_price)">
                                    {{ __('dashboard/product/validation.price_more_compare_price') }}
                                </div>
                            </div>
                            <!-- Discounted Price -->
                            <div class="mb-3">
                                <label for="compare_price"
                                       class="form-label">{{ __('dashboard/product/create.compare_price') }}</label>
                                <input class="form-control" type="text" id="compare_price"
                                       name="compare_price"
                                       x-model="compare_price"
                                />
                                <x-input-error key="compare_price"/>
                            </div>
                            <!-- Charge tax check box -->
                            <div
                                class="form-check mb-2 d-flex justify-content-start align-content-center gap-5 border-top pt-3">
                                <div class="fw-semibold mb-3">{{ __('dashboard/product/create.feature') }}</div>
                                <label class="switch switch-lg ">
                                    <input type="checkbox"
                                           name="feature"
                                           @checked( old('feature'))
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
                                <x-input-error key="feature"/>
                            </div>
                            <!-- Instock switch -->
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <span class="mb-0 h6">In stock</span>
                                <div class="w-25 d-flex justify-content-end">
                                    <label class="switch switch-primary switch-sm me-4 pe-2">
                                        <input type="checkbox" class="switch-input" checked="">
                                        <span class="switch-toggle-slider">
                  <span class="switch-on">
                    <span class="switch-off"></span>
                  </span>
                </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Pricing Card -->
                    <!-- Organize Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('dashboard/product/edit.product_details') }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Vendor -->
                            <div class="mb-3 col ecommerce-select2-dropdown">
                                <label for="store_id"
                                       class="form-label">{{ __('dashboard/product/create.store') }}</label>
                                <div class="select2-dark">
                                    <select id="store_id" class="select2 form-select" name="store_id">
                                        <option value>{{ __('dashboard/product/create.no_store') }}</option>
                                        @foreach($stores as $store)
                                            <option
                                                @selected( old('store_id') == $store->id) value="{{ $store->id }}">{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error key="store_id"/>
                            </div>
                            <!-- Category -->
                            <div class="mb-3 col ecommerce-select2-dropdown">
                                <label for="category_id"
                                       class="form-label">{{ __('dashboard/product/create.category') }}</label>
                                <div class="select2-dark">
                                    <select id="category_id" class="select2 form-select" name="category_id">
                                        <option value>{{ __('dashboard/product/create.no_category') }}</option>
                                        @foreach($categories as $category)
                                            <option
                                                @selected( old('category_id') == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error key="category_id"/>
                            </div>

                            <!-- Status -->
                            <div class="mb-3 col ecommerce-select2-dropdown">
                                <label for="status"
                                       class="form-label">{{ __('dashboard/product/create.status') }}</label>
                                <div class="select2-dark">
                                    <select id="status" class="select2 form-select" name="status">
                                        <option value>{{ __('dashboard/product/create.no_status') }}</option>
                                        @foreach(\App\Models\Product::statusValues() as $key => $status)
                                            <option
                                                @selected(  old('status') == $key ) value="{{ $key }}">{{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error key="status"/>
                            </div>

                            <div class="mb-3 col ecommerce-select2-dropdown">
                                <label for="tag_id"
                                       class="form-label">{{ __('dashboard/product/create.tag') }}</label>
                                <div class="select2-dark">
                                    <select id="tag_id" class="select2 form-select" multiple name="tag_id[]">
                                        @foreach($tags as $tag)
                                            <option
                                                @selected( in_array( $tag->id, old('tag_id') ?? [] ) ) value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error key="tag_id"/>
                            </div>
                        </div>
                    </div>
                    <!-- /Organize Card -->
                </div>
                <!-- /Second column -->
            </div>

            <div class=" mt-3">
                <button class="btn btn-primary w-100"
                        title="{{ __('dashboard/product/create.submit_btn') }}">{{ __('dashboard/product/create.submit_btn') }}</button>
            </div>
        </form>
    </div>

    @include('dashboard.partials.toast')

@endsection

@push('js')

    @vite(['resources/js/app.js'])

    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>


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

