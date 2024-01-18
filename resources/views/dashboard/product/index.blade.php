@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/product/index.title') }}
@endsection

@push('css')
    @vite(['resources/js/app.js'])
@endpush



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <h4 class="fw-bold py-3 mb-4">
            <a class="text-muted fw-light"
               href="{{ route('dashboard.products.index') }}">{{ __('dashboard/product/index.breadcrumb_1') }}</a>
            /
            {{ __('dashboard/product/index.breadcrumb_2') }}
        </h4>
        <!-- /Breadcrumb -->


        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>{{ __('dashboard/product/index.all_product') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ \App\Models\Product::cachedCount() }}</h4>
                                    <small class="text-success">(+29%)</small>
                                </div>
                                <small>Total Users</small>
                            </div>
                            <span class="badge bg-label-primary rounded p-2">
                                <i class='bx bx-cabinet bx-burst'></i>
          </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>{{ __('dashboard/product/index.active_product') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ \App\Models\Product::activeCachedCount() }}</h4>
                                    <small
                                        class="text-success">({{ round((\App\Models\Product::activeCachedCount() / \App\Models\Product::cachedCount() ) * 100,2)  }}
                                        %)</small>
                                </div>
                                <small>Last week analytics </small>
                            </div>
                            <span class="badge bg-label-success rounded p-2">
                                <i class='bx bxs-bolt bx-tada'></i>
          </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>{{ __('dashboard/product/index.draft_product') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ \App\Models\Product::draftCachedCount() }}</h4>
                                    <small
                                        class="text-danger">({{ round((\App\Models\Product::draftCachedCount() / \App\Models\Product::cachedCount() ) * 100,2)  }}
                                        %)</small>
                                </div>
                                <small>Last week analytics</small>
                            </div>
                            <span class="badge bg-label-warning rounded p-2">
                                <i class='bx bxs-watch'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>{{ __('dashboard/product/index.inactive_product') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ \App\Models\Product::inactiveCachedCount() }}</h4>
                                    <small
                                        class="text-success">({{ round(( \App\Models\Product::inactiveCachedCount()/ \App\Models\Product::cachedCount() ) * 100,2) }}
                                        %)</small>
                                </div>
                                <small>Last week analytics</small>
                            </div>
                            <span class="badge bg-label-warning rounded p-2">
                                <i class='bx bxs-hand'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>{{ __('dashboard/product/index.archive_product') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ \App\Models\Product::archiveCachedCount() }}</h4>
                                    <small
                                        class="text-success">({{ round(( \App\Models\Product::archiveCachedCount() / \App\Models\Product::cachedCount() ) * 100,2) }}
                                        %)</small>
                                </div>
                                <small>Last week analytics</small>
                            </div>
                            <span class="badge bg-label-danger rounded p-2">
                                <i class='bx bxs-archive'></i>
                             </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-header">{{ __('dashboard/product/index.card_header') }}</h5>
                        <a class="btn btn-primary me-4 rounded-0"
                           href="{{ route('dashboard.products.create') }}">{{ __('dashboard/product/index.add_btn') }}</a>
                    </div>
                    <div class="table-responsive text-nowrap table-hover">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('dashboard/product/index.name') }}</th>
                                <th>{{ __('dashboard/product/index.store') }}</th>
                                <th>{{ __('dashboard/product/index.category') }}</th>
                                <th>{{ __('dashboard/product/index.price') }}</th>
                                <th>{{ __('dashboard/product/index.status') }}</th>
                                <th>{{ __('dashboard/product/index.action') }}</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @forelse($products as $product)
                                <tr
{{--                                    x-data="{badge: {{$product->status->value }} }"--}}
                                >
                                    <td>{{ $loop->iteration }}</td>


                                    <td class="">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-wrapper me-2 rounded-2 bg-label-secondary">
                                                <div class="avatar">
                                                    <a href="{{ $product->getFirstMediaUrl('logo') }}" target="_blank">
                                                        <img
                                                            src="{{ $product->getFirstMediaUrl('logo') }}"
                                                            title="{{ $product->name }}"
                                                            alt="{{ $product->slug }}" class="rounded-2 pull-up">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <span class="text-body text-wrap fw-medium">
                                                    <a title="{{ $product->name }}"
                                                       href="{{ route('dashboard.products.show', $product) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </span>
                                                <span class="text-muted text-truncate mb-0 d-none d-sm-block">
                                                    <small>{{ $product->slug }}</small>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $product->store?->name }}</td>
                                    <td>{{ $product->category?->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td><span

{{--                                            class="badge me-1"--}}
{{--                                            :class="{ 'bg-label-primary': badge === 1, 'bg-label-danger': badge === 2, 'bg-label-warning': badge ===3  }"--}}


                                            @class([
                                                    "badge me-1",
                                                    "bg-label-primary" => $product->status == ProductStatus::ACTIVE,
                                                    "bg-label-danger" => $product->status == ProductStatus::INACTIVE,
                                                    "bg-label-warning" => $product->status == ProductStatus::DRAFT,

                                                    ])
                                        >
                                            {{ $product->readableStatus }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                   title="{{ __('dashboard/roduct/index.edit') }}"
                                                   href="{{ route('dashboard.products.edit', $product) }}">
                                                    <i class="bx bx-edit-alt me-1"></i>{{ __('dashboard/product/index.edit') }}
                                                </a>


                                                <form action="{{ route('dashboard.products.destroy',$product) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="{{ __('dashboard/product/index.delete') }}"
                                                            class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i>
                                                        {{ __('dashboard/product/index.delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="text-center">{{ __('dashboard/product/index.no_date') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 px-4">
                            {{ $products->links() }}
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
            @vite(['resources/js/app.js'])
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

