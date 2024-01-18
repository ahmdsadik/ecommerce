<div class="cart-items">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-cart"></i>
        <span class="total-items">{{ $items->count() }}</span>
    </a>
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span>{{ $items->count() }}</span>
            <a href="{{ route('front.cart.index') }}">View Cart</a>
        </div>
        <ul class="shopping-list">
            @foreach($items as $item)
                <li>
                    <div class="cart-img-head">
                        <a class="cart-img" href="{{ route('front.products.show', $item) }}"><img
                                src="{{ $item->getFirstMediaUrl('logo') }}"
                                alt="#"></a>
                    </div>

                    <div class="content">
                        <h4>
                            <a href="{{ route('front.products.show',$item) }}">
                                {{ $item->name }}
                            </a>
                        </h4>
                        <p class="quantity">{{ $item->details->qty }}x - <span
                                class="amount">${{ round($item->details->qty * $item->price,2) }}</span></p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="bottom">
            <div class="total">
                <span>Total</span>
                <span class="total-amount">${{ $total }}</span>
            </div>
            <div class="button">
                <a href="{{ route('front.checkout') }}" class="btn animate">Checkout</a>
            </div>
        </div>
    </div>
</div>
