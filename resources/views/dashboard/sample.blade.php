@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/category/index.title') }}
@endsection

@push('css')




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
                    <h5 class="card-header">Table Basic</h5>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.partials.toast')

@endsection

@push('js')



@endpush

