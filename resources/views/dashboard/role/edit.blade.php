@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/role/edit.title') }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <a class="text-muted fw-light"
               href="{{ route('dashboard.roles.index') }}">{{ __('dashboard/role/edit.breadcrumb_1') }}</a>
            /
            {{ __('dashboard/role/edit.breadcrumb_2') }}
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
                    <h5 class="card-header">{{ __('dashboard/role/edit.card_header') }}</h5>

                    <div class="card-body">
                        <form action="{{ route('dashboard.roles.update',$role) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

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
                                                       class="form-label">{{ __('dashboard/role/edit.name',['lang' => __('lang_key.with_'.$key)]) }}</label>
                                                <input class="form-control" type="text" id="display_name"
                                                       name="{{$key}}[display_name]"
                                                       placeholder="{{ __('dashboard/role/edit.name_placeholder',['lang' => __('lang_key.with_'.$key)]) }}"
                                                       value="{{ old($key.'.display_name',$role->translate($key)?->display_name) }}"/>
                                                <x-input-error key="{{$key .'.display_name'}}"/>

                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <h5 class="card-title fs-5 mt-4 text-center">الصلاحيات</h5>

                            <div class="row mt-3 p-2 g-3">
                                @forelse($permissions as $permission )
                                    <div class="form-check form-check-reverse fs-5 col-6 col-md-4 col-lg-3 col-xl-2">
                                        <input class="form-check-input" type="checkbox"
                                               name="permissions[]"
                                               @checked(in_array( $permission->id, old('permissions', $role_permissions)  ))
                                               value="{{ $permission->id }}"
                                               id="per-{{ $permission->id }}">
                                        <label class="form-check-label" for="per-{{ $permission->id }}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                @empty
                                    <div class="alert alert-danger" role="alert">
                                        لا يوجد
                                    </div>
                                @endforelse

                            </div>

                            <div class="card-footer mt-3">
                                <button class="btn btn-primary w-100"
                                        title="{{ __('dashboard/role/edit.submit_btn') }}">
                                    {{ __('dashboard/role/edit.submit_btn') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


