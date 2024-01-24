@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/category/index.title') }}
@endsection

@push('css')
    @vite(['resources/js/app.js'])
@endpush



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <h4 class="fw-bold py-3 mb-4">
            <a class="text-muted fw-light"
               href="{{ route('dashboard.categories.index') }}">{{ __('dashboard/category/index.breadcrumb_1') }}</a>
            /
            {{ __('dashboard/category/index.breadcrumb_2') }}
        </h4>
        <!-- /Breadcrumb -->


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @permission('category_create')
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-header">{{ __('dashboard/category/index.card_header') }}</h5>
                        <a class="btn btn-primary me-4 rounded-0"
                           href="{{ route('dashboard.categories.create') }}">{{ __('dashboard/category/index.add_btn') }}</a>
                    </div>
                    @endpermission
                    <div class="table-responsive text-nowrap table-hover">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('dashboard/category/index.name') }}</th>
                                <th>{{ __('dashboard/category/index.parent') }}</th>
                                <th>{{ __('dashboard/category/index.status') }}</th>
                                <th>{{ __('dashboard/category/index.action') }}</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-wrapper me-2 rounded-2 bg-label-secondary">
                                                <div class="avatar">
                                                    <a href="{{ $category->getFirstMediaUrl('logo') }}" target="_blank">
                                                        <img
                                                            src="{{ $category->getFirstMediaUrl('logo') }}"
                                                            title="{{ $category->name }}"
                                                            alt="{{ $category->slug }}" class="rounded-2 pull-up">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <span class="text-body text-wrap fw-medium">
                                                    <a title="{{ $category->name }}"
                                                       href="{{ route('dashboard.categories.show', $category) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </span>
                                                <span class="text-muted text-truncate mb-0 d-none d-sm-block">
                                                    <small>{{ $category->slug }}</small>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $category->parent?->name }}</td>
                                    <td><span
                                            @class([
                                                    "badge me-1",
                                                    "bg-label-primary" => $category->status == CategoryStatus::ACTIVE,
                                                    "bg-label-danger" => $category->status == CategoryStatus::INACTIVE

                                                    ])
                                        >
                                            {{ $category->readableStatus }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                @permission('category_update')
                                                <a class="dropdown-item"
                                                   title="{{ __('dashboard/category/index.edit') }}"
                                                   href="{{ route('dashboard.categories.edit', $category) }}">
                                                    <i class="bx bx-edit-alt me-1"></i>{{ __('dashboard/category/index.edit') }}
                                                </a>
                                                @endpermission

                                                @permission('category_delete')
                                                <form action="{{ route('dashboard.categories.destroy',$category) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="{{ __('dashboard/category/index.delete') }}"
                                                            class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i>
                                                        {{ __('dashboard/category/index.delete') }}
                                                    </button>
                                                </form>
                                                @endpermission
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="text-center">{{ __('dashboard/category/index.no_date') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 px-4">
                            {{ $categories->links() }}
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

