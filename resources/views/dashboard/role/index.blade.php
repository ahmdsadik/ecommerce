@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/role/index.title') }}
@endsection

{{--@push('css')--}}
{{--    @vite(['resources/js/app.js'])--}}
{{--@endpush--}}
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <h4 class="fw-bold py-3 mb-4">
            <a class="text-muted fw-light"
               href="{{ route('dashboard.roles.index') }}">{{ __('dashboard/role/index.breadcrumb_1') }}</a>
            /
            {{ __('dashboard/role/index.breadcrumb_2') }}
        </h4>
        <!-- /Breadcrumb -->


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @permission('role_create')
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-header">{{ __('dashboard/role/index.card_header') }}</h5>
                        <a class="btn btn-primary me-4 rounded-0"
                           href="{{ route('dashboard.roles.create') }}">{{ __('dashboard/role/index.add_btn') }}</a>
                    </div>
                    @endpermission
                    <div class="table-responsive text-nowrap ">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('dashboard/role/index.name') }}</th>
                                <th>{{ __('dashboard/role/index.action') }}</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.roles.edit', $role) }}">
                                            <span class="fw-medium">{{ $role->display_name }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                @permission('role_update')
                                                <a class="dropdown-item"
                                                   title="{{ __('dashboard/role/index.edit') }}"
                                                   href="{{ route('dashboard.roles.edit', $role) }}">
                                                    <i class="bx bx-edit-alt me-1"></i>{{ __('dashboard/role/index.edit') }}
                                                </a>
                                                @endpermission
                                                @permission('role_delete')
                                                <form action="{{ route('dashboard.roles.destroy', $role) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="{{ __('dashboard/role/index.delete') }}"
                                                            class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i>
                                                        {{ __('dashboard/role/index.delete') }}
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
                                        class="text-center">{{ __('dashboard/role/index.no_date') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 px-4">
                            {{ $roles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Toast with Animation -->
        @include('dashboard.partials.toast')
        <!-- /Toast with Animation -->
@endsection

@session('msg')
    @push('js')

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

    @endpush
@endsession