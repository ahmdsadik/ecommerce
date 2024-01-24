@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/store/index.title') }}
@endsection

@push('css')
    @vite(['resources/js/app.js'])
@endpush



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <h4 class="fw-bold py-3 mb-4">
            <a class="text-muted fw-light"
               href="{{ route('dashboard.stores.index') }}">{{ __('dashboard/store/index.breadcrumb_1') }}</a>
            /
            {{ __('dashboard/store/index.breadcrumb_2') }}
        </h4>
        <!-- /Breadcrumb -->


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @permission('store_create')
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-header">{{ __('dashboard/store/index.card_header') }}</h5>
                        <a class="btn btn-primary me-4 rounded-0"
                           href="{{ route('dashboard.stores.create') }}">{{ __('dashboard/store/index.add_btn') }}</a>
                    </div>
                    @endpermission
                    <div class="table-responsive text-nowrap table-hover">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('dashboard/store/index.name') }}</th>
                                <th>{{ __('dashboard/store/index.status') }}</th>
                                <th>{{ __('dashboard/store/index.action') }}</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($stores as $store)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
{{--                                    <td class="d-flex align-items-center gap-2">--}}
{{--                                        <div class="avatar avatar-md">--}}
{{--                                            <a href="{{ $store->getFirstMediaUrl('logo') }}" target="_blank">--}}
{{--                                                <img src="{{ $store->getFirstMediaUrl('logo') }}" alt="Avatar"--}}
{{--                                                     class="rounded-circle pull-up">--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex flex-column">--}}
{{--                                            <a title="{{ $store->name }}"--}}
{{--                                               href="{{ route('dashboard.stores.show', $store) }}">--}}
{{--                                                <span class="fw-medium">{{ $store->name }}</span>--}}
{{--                                            </a>--}}
{{--                                            <span class="text-muted">--}}
{{--                                                {{ $store->slug }}--}}
{{--                                            </span>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}

                                    <td class="">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-wrapper me-2 rounded-2 bg-label-secondary">
                                                <div class="avatar">
                                                    <a href="{{ $store->getFirstMediaUrl('logo') }}" target="_blank">
                                                        <img
                                                            src="{{ $store->getFirstMediaUrl('logo') }}"
                                                            title="{{ $store->name }}"
                                                            alt="{{ $store->slug }}" class="rounded-2 pull-up">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <span class="text-body text-wrap fw-medium">
                                                    <a title="{{ $store->name }}"
                                                       href="{{ route('dashboard.categories.show', $store) }}">
                                                        {{ $store->name }}
                                                    </a>
                                                </span>
                                                <span class="text-muted text-truncate mb-0 d-none d-sm-block">
                                                    <small>{{ $store->slug }}</small>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span
                                            @class([
                                                    "badge me-1",
                                                    "bg-label-primary" => $store->status == \StoreStatus::ACTIVE,
                                                    "bg-label-danger" => $store->status == \StoreStatus::INACTIVE

                                                    ])
                                        >
                                            {{ $store->readableStatus }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                @permission('store_update')

                                                <a class="dropdown-item"
                                                   title="{{ __('dashboard/store/index.edit') }}"
                                                   href="{{ route('dashboard.stores.edit', $store) }}">
                                                    <i class="bx bx-edit-alt me-1"></i>{{ __('dashboard/store/index.edit') }}
                                                </a>
                                                @endpermission
                                                @permission('store_delete')
                                                <form action="{{ route('dashboard.stores.destroy',$store) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="{{ __('dashboard/store/index.delete') }}"
                                                            class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i>
                                                        {{ __('dashboard/store/index.delete') }}
                                                    </button>
                                                </form>
                                                @endpermission
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="text-center">{{ __('dashboard/store/index.no_date') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 px-4">
                            {{ $stores->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast with Animation -->
        @include('dashboard.partials.toast')
        <!-- /Toast with Animation -->

        @endsection

        @push('js')
            @if(session()->has('msg'))
                <!-- Toast JS -->
                <script src="{{ asset('assets/dashboard/vendor/libs/toastr/toastr.js') }}"></script>

                <script src="{{ asset('assets/dashboard/js/ui-toasts.js') }}"></script>

                <script>
                    const toastAnimationExample = document.querySelector('.toast-ex');
                    // let toastAnimation;
                    // if (toastAnimation) {
                    //     toastDispose(toastAnimation);
                    // }
                    selectedType = 'bg-primary';
                    selectedAnimation = 'animate__bounce';

                    toastAnimationExample.classList.add(selectedType, selectedAnimation);
                    toastAnimation = new bootstrap.Toast(toastAnimationExample);
                    toastAnimation.show();
                </script>
    @endif

    @endpush

