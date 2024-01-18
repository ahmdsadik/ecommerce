@extends('dashboard.layouts.app')

@section('title')
    {{ __('dashboard/product/create.title') }}
@endsection

{{--@section('title', 'eCommerce Add Product - Apps')--}}

@push('css')

    <link rel="stylesheet" href="{{asset('assets/dashboard/vendor/libs/quill/typography.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/dashboard/vendor/libs/quill/katex.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/dashboard/vendor/libs/quill/editor.css')}}"/>

    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/libs/select2/select2.css') }}"/>


    <link rel="stylesheet" href="{{asset('assets/dashboard/vendor/libs/dropzone/dropzone.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/dashboard/vendor/libs/flatpickr/flatpickr.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/dashboard/vendor/libs/tagify/tagify.css')}}"/>
@endpush

@push('js')
    <script src="{{asset('assets/dashboard/vendor/libs/quill/katex.js')}}"></script>
    <script src="{{asset('assets/dashboard/vendor/libs/quill/quill.js')}}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('assets/dashboard/vendor/libs/select2/select2.js') }}"></script>


    <!-- Page JS -->
    {{--    <script src="{{ asset('assets/dashboard/js/forms-selects.js') }}"></script>--}}

    <script src="{{asset('assets/dashboard/vendor/libs/dropzone/dropzone.js')}}"></script>
    <script src="{{asset('assets/dashboard/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
    <script src="{{asset('assets/dashboard/vendor/libs/flatpickr/flatpickr.js')}}"></script>
    <script src="{{asset('assets/dashboard/vendor/libs/tagify/tagify.js')}}"></script>

{{--        <script src="{{ asset('assets/dashboard/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>--}}

    <script src="{{asset('assets/dashboard/js/app-ecommerce-product-add.js')}}"></script>
{{--        <script src="{{ asset('assets/dashboard/js/forms-extras.js') }}"></script>--}}

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">eCommerce /</span><span> Add Product</span>
        </h4>

        <div class="app-ecommerce">

            <!-- Add Product -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1 mt-3">Add a new Product</h4>
                    <p class="text-muted">Orders placed across your store</p>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-3">
                    <button class="btn btn-label-secondary">Discard</button>
                    <button class="btn btn-label-primary">Save draft</button>
                    <button type="submit" class="btn btn-primary">Publish product</button>
                </div>

            </div>

                <button type="submit">Add Data</button>

                <div class="row">


                    <!-- First column-->
                    <div class="col-12 col-lg-8">
                        <!-- Product Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Product information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="ecommerce-product-name">Name</label>
                                    <input type="text" class="form-control" id="ecommerce-product-name"
                                           placeholder="Product title" name="productTitle" aria-label="Product title">
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><label class="form-label" for="ecommerce-product-sku">SKU</label>
                                        <input type="number" class="form-control" id="ecommerce-product-sku"
                                               placeholder="SKU" name="productSku" aria-label="Product SKU"></div>
                                    <div class="col"><label class="form-label"
                                                            for="ecommerce-product-barcode">Barcode</label>
                                        <input type="text" class="form-control" id="ecommerce-product-barcode"
                                               placeholder="0123-4567" name="productBarcode"
                                               aria-label="Product barcode"></div>
                                </div>
                                <!-- Description -->
                                <div>
                                    <label class="form-label">Description <span
                                            class="text-muted">(Optional)</span></label>
                                    <div class="form-control p-0 pt-1">
                                        <div class="comment-toolbar border-0 border-bottom">
                                            <div class="d-flex justify-content-start">
                  <span class="ql-formats me-0">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                    <button class="ql-underline"></button>
                    <button class="ql-list" value="ordered"></button>
                    <button class="ql-list" value="bullet"></button>
                    <button class="ql-link"></button>
                    <button class="ql-image"></button>
                  </span>
                                            </div>
                                        </div>
                                        <div class="comment-editor border-0 pb-4" id="ecommerce-category-description">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Product Information -->

                    </div>
                    <!-- /Second column -->

                    <!-- Second column -->
                    <div class="col-12 col-lg-4">
                        <!-- Pricing Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Pricing</h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <div class="mb-3">
                                    <label class="form-label" for="ecommerce-product-price">Base Price</label>
                                    <input type="number" class="form-control" id="ecommerce-product-price"
                                           placeholder="Price" name="productPrice" aria-label="Product price">
                                </div>
                                <!-- Discounted Price -->
                                <div class="mb-3">
                                    <label class="form-label" for="ecommerce-product-discount-price">Discounted
                                        Price</label>
                                    <input type="number" class="form-control" id="ecommerce-product-discount-price"
                                           placeholder="Discounted Price" name="productDiscountedPrice"
                                           aria-label="Product discounted price">
                                </div>
                                <!-- Charge tax check box -->
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="price-charge-tax"
                                           checked>
                                    <label class="form-label" for="price-charge-tax">
                                        Charge tax on this product
                                    </label>
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
                                <h5 class="card-title mb-0">Organize</h5>
                            </div>
                            <div class="card-body">
                                <!-- Vendor -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="vendor">
                                        Vendor
                                    </label>
                                    <select id="vendor" class="select2 form-select" data-placeholder="Select Vendor">
                                        <option value="">Select Vendor</option>
                                        <option value="men-clothing">Men's Clothing</option>
                                        <option value="women-clothing">Women's-clothing</option>
                                        <option value="kid-clothing">Kid's-clothing</option>
                                    </select>
                                </div>
                                <!-- Category -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                           for="category-org">
                                    </label>
                                    <select id="category-org" class="select2 form-select"
                                            data-placeholder="Select Category">
                                        <option value="">Select Category</option>
                                        <option value="Household">Household</option>
                                        <option value="Management">Management</option>
                                        <option value="Electronics">Electronics</option>
                                        <option value="Office">Office</option>
                                        <option value="Automotive">Automotive</option>
                                    </select>
                                </div>


                                <!-- Collection -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="collection">Collection
                                    </label>
                                    <select id="collection" class="select2 form-select" data-placeholder="Collection">
                                        <option value="">Collection</option>
                                        <option value="men-clothing">Men's Clothing</option>
                                        <option value="women-clothing">Women's-clothing</option>
                                        <option value="kid-clothing">Kid's-clothing</option>
                                    </select>
                                </div>
                                <!-- Status -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="status-org">Status
                                    </label>
                                    <select id="status-org" class="select2 form-select" data-placeholder="Published">
                                        <option value="">Published</option>
                                        <option value="Published">Published</option>
                                        <option value="Scheduled">Scheduled</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /Organize Card -->
                    </div>
                    <!-- /Second column -->

                </div>
        </div>
    </div>
@endsection
