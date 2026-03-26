@php
$subtotal = 0;
@endphp

<ul class="woocommerce-mini-cart cart_list product_list_widget">

    @if(count($cartItems))

    @foreach($cartItems as $item)

    @php
    // 🔥 UNIFIED (DB + SESSION)
    $productId = is_array($item) ? $item['id'] : $item->product->id;
    $name = is_array($item) ? $item['name'] : $item->product->name;
    $qty = is_array($item) ? $item['qty'] : $item->qty;
    $price = is_array($item) ? $item['price'] : $item->price;
    $image = is_array($item) ? $item['image'] : $item->product->image;

    $subtotal += $price * $qty;
    @endphp

    <li class="woocommerce-mini-cart-item mini_cart_item">

        <span onclick="removeItem({{ $productId }})" style="cursor:pointer;color:red;font-size:18px;">
            ❌
        </span>

        <a href="#">
            <img src="{{ asset('storage/'.$image) }}">
            {{ $name }}
        </a>

        <span class="quantity">
            {{ $qty }} × ₹{{ $price }}
        </span>
    </li>

    @endforeach

    @else
    <li class="text-center">Cart is empty</li>
    @endif

</ul>

<p class="woocommerce-mini-cart__total total">
    <strong>Subtotal:</strong> ₹{{ $subtotal }}
</p>

<p class="woocommerce-mini-cart__buttons buttons">
    <a href="{{ route('cart.index') }}" class="th-btn w-100">
        View Cart
    </a>
</p>