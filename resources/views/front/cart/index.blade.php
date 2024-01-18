<x-front title="Cart">

    <x-slot:breadcrumb>
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Cart</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li>Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->
    </x-slot:breadcrumb>

    <!-- Shopping Cart -->
    <div x-data="{
                    total:{{ $total}},
                    updateItemAndCart(plusOrMinus, qty, item_price){

                    if (qty < 1) return item_price;

                    this.total = parseFloat((plusOrMinus ? (this.total + item_price) : (this.total - item_price)).toFixed(2));

                    return (qty * item_price).toFixed(2);
                    }
    }" class="shopping-cart section">
        <div class="container">
            <div class="cart-list-head">
                <!-- Cart List Title -->
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12">

                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>Product Name</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Quantity</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Subtotal</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Discount</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>Remove</p>
                        </div>
                    </div>
                </div>
                <!-- End Cart List Title -->
                <!-- Cart Single List list -->
                @forelse($cart as $item)
                    <div id="{{ $item->id }}" class="cart-single-list"
                         x-data="{
                                            qty: {{ $item->details->qty }} ,
                                            itemTotal: {{ round($item->details->qty * $item->price,2) }}
                                }"
                    >
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-1 col-12">
                                <a href="{{ route('front.products.show',$item) }}">

                                    <img src="{{ $item->getFirstMediaUrl('logo') }}"
                                         title="{{ $item->name }}"
                                         alt="{{ $item->name }}">
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <h5 class="product-name">
                                    <a href="{{ route('front.products.show',$item) }}">
                                        {{ $item->name }}
                                    </a></h5>
                                <p class="product-des">
                                    <span><em>Type:</em> Mirrorless</span>
                                    <span><em>Color:</em> Black</span>
                                </p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <div class="count-input" >
                                    <input type="number"
                                           x-init="$watch('qty', (value, old) => itemTotal = updateItemAndCart(value > old, qty , {{ $item->price }} ) )"
                                           x-model="qty"
                                           class="form-control" min="1"
                                           name="qty">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p x-text="itemTotal"></p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>$29.00</p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <a class="remove-item" data-id="{{ $item->id }}" href="javascript:void(0)"><i
                                        class="lni lni-close"></i></a>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="cart-single-list">
                        <div class="row align-items-center">
                            <div class="text-center">No items Found</div>
                        </div>
                    </div>

                @endforelse
                <!-- End Single List list -->
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form action="#" target="_blank">
                                            <input name="Coupon" placeholder="Enter Your Coupon">
                                            <div class="button">
                                                <button class="btn">Apply Coupon</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        <li>Cart Subtotal<span x-text="`$${total}`"></span></li>
                                        <li>Shipping<span>Free</span></li>
                                        <li>You Save<span>$29.00</span></li>
                                        <li class="last">You Pay<span>$2531.00</span></li>
                                    </ul>
                                    <div class="button">
                                        <a href="{{ route('front.checkout') }}" class="btn">Checkout</a>
                                        <a href="{{ route('front.products.index') }}" class="btn btn-alt">Continue
                                            shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->


    @push('scripts')

        @vite(['resources/js/app.js'])

        <script>
            const csrf_token = '{{ csrf_token() }}';
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
                integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('assets/front/js/cart.js') }}"></script>
    @endpush


</x-front>
