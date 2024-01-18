@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/product/edit.title') }}
@endsection

@push('css')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/libs/select2/select2.css') }}"/>
@endpush



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <a class="text-muted fw-light"
               href="{{ route('dashboard.products.index') }}">{{ __('dashboard/product/edit.breadcrumb_1') }}</a>
            /
            {{ __('dashboard/product/edit.breadcrumb_2') }}
        </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">{{ __('dashboard/product/edit.card_header') }}</h5>

                    <div class="card-body">
                        <form action="{{ route('dashboard.products.update',$product) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ $product->getFirstMediaUrl('logo') }}"
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

                            <hr class="mt-3 mb-4">

                            <div class="col-md-6 mb-4">
                                <label for="slug"
                                       class="form-label">{{ __('dashboard/product/edit.slug') }}</label>
                                <input class="form-control" type="text" id="slug"
                                       name="slug"
                                       value="{{ old('slug',$product->slug) }}"/>
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
                                                <div class="col-md-6 mt-3 mb-3 mb-md-0">

                                                    <div class="mb-3">
                                                        <label for="name"
                                                               class="form-label">{{ __('dashboard/product/edit.name',['lang' => __('lang_key.with_'.$key)]) }}</label>
                                                        <input class="form-control" type="text" id="name"
                                                               name="{{$key}}[name]"
                                                               value="{{ old($key .'.name' , $product->translate($key)?->name) }}"
                                                               placeholder="{{ __('dashboard/product/edit.name_placeholder',['lang' => __('lang_key.with_'.$key)]) }}"
                                                        />
                                                        <x-input-error key="{{$key .'.name'}}"/>
                                                    </div>

                                                    <div class="">
                                                        <label for="short_description"
                                                               class="form-label">{{ __('dashboard/product/edit.short_description',['lang' => __('lang_key.with_'.$key)]) }}</label>
                                                        <textarea class="form-control"
                                                                  name="{{$key}}[short_description]"
                                                                  id="short_description"
                                                                  cols="30"
                                                                  rows="5">{{ old($key .'.short_description',$product->translate($key)?->short_description) }}</textarea>

                                                        <x-input-error key="{{$key .'.short_description'}}"/>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="description"
                                                           class="form-label">{{ __('dashboard/product/edit.description',['lang' => __('lang_key.with_'.$key)]) }}</label>
                                                    <textarea class="form-control" name="{{$key}}[description]"
                                                              id="description"
                                                              cols="30"
                                                              rows="8">{{ old($key .'.description',$product->translate($key)?->description) }}</textarea>

                                                    <x-input-error key="{{$key .'.description'}}"/>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="row g-3">

                                <div class="col-md-6 ">
                                    <label for="category_id"
                                           class="form-label">{{ __('dashboard/product/edit.category') }}</label>
                                    <div class="select2-dark">
                                        <select id="category_id" class="select2 form-select" name="category_id">
                                            <option value>{{ __('dashboard/product/edit.no_category') }}</option>
                                            @foreach($categories as $category)
                                                <option
                                                        @selected( old('category_id', $product->category_id) == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-input-error key="category_id"/>
                                </div>

                                <div class="col-md-6 ">
                                    <label for="store_id"
                                           class="form-label">{{ __('dashboard/product/edit.store') }}</label>
                                    <div class="select2-dark">
                                        <select id="store_id" class="select2 form-select" name="store_id">
                                            <option value>{{ __('dashboard/product/edit.no_store') }}</option>
                                            @foreach($stores as $store)
                                                <option
                                                        @selected( old('store_id',$product->store_id) == $store->id) value="{{ $store->id }}">{{ $store->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-input-error key="store_id"/>
                                </div>

                                <div class="col-md-6  ">
                                    <label for="tag_id"
                                           class="form-label">{{ __('dashboard/product/edit.tag') }}</label>
                                    <div class="select2-dark">
                                        <select id="tag_id" class="select2 form-select" multiple name="tag_id[]">
                                            @foreach($tags as $tag)
                                                <option
                                                        @selected( in_array( $tag->id, old('tag_id',$product->tags->pluck('id')->toArray())  ) ) value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-input-error key="tag_id"/>
                                </div>

                                <div class="col-md-6  ">
                                    <label for="status"
                                           class="form-label">{{ __('dashboard/product/edit.status') }}</label>
                                    <div class="select2-dark">
                                        <select id="status" class="select2 form-select" name="status">
                                            @foreach(\App\Models\Product::statusValues() as $key => $status)
                                                <option
                                                        @selected(  old('status',$product->status->value) == $key ) value="{{ $key }}">{{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-input-error key="status"/>
                                </div>

                                <div class="col-md-6 row mt-4">
                                    <div class="col-md-6 ">
                                        <label for="price"
                                               class="form-label">{{ __('dashboard/product/edit.price') }}</label>
                                        <input class="form-control" type="text" id="price"
                                               name="price"
                                               value="{{ old('price',$product->price) }}"/>
                                        <x-input-error key="price"/>
                                    </div>

                                    <div class="col-md-6 mt-3 mt-md-0">
                                        <label for="compare_price"
                                               class="form-label">{{ __('dashboard/product/edit.compare_price') }}</label>
                                        <input class="form-control" type="text" id="compare_price"
                                               name="compare_price"
                                               value="{{ old('compare_price',$product->compare_price) }}"/>
                                        <x-input-error key="compare_price"/>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="fw-semibold mb-3">{{ __('dashboard/product/edit.feature') }}</div>
                                    <label class="switch switch-lg">
                                        <input type="checkbox"
                                               name="feature"
                                               @checked( old('feature',$product->feature))
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


                            </div>


                            <div class="card-footer mt-3">
                                <button class="btn btn-primary w-100"
                                        title="{{ __('dashboard/product/edit.submit_btn') }}">{{ __('dashboard/product/edit.submit_btn') }}</button>
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

