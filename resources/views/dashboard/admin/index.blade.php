@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/admin/index.title') }}
@endsection


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <h4 class="fw-bold py-3 mb-4">
            <a class="text-muted fw-light"
               href="{{ route('dashboard.admins.index') }}">{{ __('dashboard/admin/index.breadcrumb_1') }}</a>
            /
            {{ __('dashboard/admin/index.breadcrumb_2') }}
        </h4>
        <!-- /Breadcrumb -->


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @permission('user_create')
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-header">{{ __('dashboard/admin/index.card_header') }}</h5>
                        <a class="btn btn-primary me-4 rounded-0"
                           href="{{ route('dashboard.admins.create') }}">{{ __('dashboard/admin/index.add_btn') }}</a>
                    </div>
                    @endpermission
                    <div class="table-responsive text-nowrap table-hover">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('dashboard/admin/index.name') }}</th>
                                <th>{{ __('dashboard/admin/index.role') }}</th>
                                <th>{{ __('dashboard/admin/index.status') }}</th>
                                <th>{{ __('dashboard/admin/index.action') }}</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($admins as $admin)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-wrapper me-2 rounded-2 bg-label-secondary">
                                                <div class="avatar">
                                                    <a href="{{ $admin->img_url }}" target="_blank">
                                                        <img
                                                                src="{{ $admin->img_url }}"
                                                                title="{{ $admin->name }}"
                                                                alt="{{ $admin->name }}"
                                                                class="rounded-2 pull-up"
                                                        >
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <span class="text-body text-wrap fw-medium">
                                                    <a title="{{ $admin->name }}"
                                                       href="">
                                                        {{ $admin->name }}
                                                    </a>
                                                </span>
                                                <span class="text-muted text-truncate mb-0 d-none d-sm-block">
                                                    <small>{{ $admin->email }}</small>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @forelse($admin->roles as $role)
                                                <span
                                            @class([
                                                    "badge me-1",
                                                    "bg-label-primary"

                                                    ])
                                        >
                                            {{ $role->display_name }}
                                        </span>

                                            @empty
                                                <span
                                            @class([
                                                    "badge me-1",
                                                    "bg-label-primary",

                                                    ])
                                        >
                                            {{ __('dashboard/admin/index.no_date') }}
                                        </span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            @class([
                                                    "badge me-1",
                                                    "bg-label-primary" => $admin->status == \App\Enums\AdminStatus::ACTIVE,
                                                    "bg-label-danger" => $admin->status == \App\Enums\AdminStatus::INACTIVE
                                                    ])
                                        >
                                            {{ $admin->readableStatus }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                @permission('user_update')
                                                <a class="dropdown-item"
                                                   title="{{ __('dashboard/admin/index.edit') }}"
                                                   href="{{ route('dashboard.admins.edit', $admin) }}">
                                                    <i class="bx bx-edit-alt me-1"></i>{{ __('dashboard/admin/index.edit') }}
                                                </a>
                                                @endpermission
                                                @permission('user_delete')
                                                <form action="{{ route('dashboard.admins.destroy',$admin) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="{{ __('dashboard/admin/index.delete') }}"
                                                            class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i>
                                                        {{ __('dashboard/admin/index.delete') }}
                                                    </button>
                                                </form>
                                                @endpermission
                                                @permission('user_update')
                                                <form action="{{ route('dashboard.reset-admin-password',$admin) }}"
                                                      method="post">
                                                    @csrf
                                                    <button title="{{ __('dashboard/admin/index.reset_password') }}"
                                                            class="dropdown-item">
                                                        <i class="bx bx-edit-alt me-1"></i>
                                                        {{ __('dashboard/admin/index.reset_password') }}
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
                                        class="text-center">{{ __('dashboard/admin/index.no_date') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 px-4">
                            {{ $admins->links() }}
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

