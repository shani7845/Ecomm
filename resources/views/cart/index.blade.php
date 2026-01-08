    @extends('layouts.app')

    @section('content')

    @php
    $subtotal = 0;
    @endphp

    <div class="th-cart-wrapper space-top space-extra-bottom">
        
        <div class="container">
            <div class="woocommerce-notices-wrapper">
                <div class="woocommerce-message">Shipping costs updated.</div>
            </div>
            <form action="javascript:void(0)" class="woocommerce-cart-form">
                <table class="cart_table">
                    <thead>
                        <tr>
                            <th class="cart-col-image">Image</th>
                            <th class="cart-col-productname">Product Name</th>
                            <th class="cart-col-price">Price</th>
                            <th class="cart-col-quantity">Quantity</th>
                            <th class="cart-col-total">Total</th>
                            <th class="cart-col-remove">Remove</th>
                        </tr>
                    </thead>
                    <tbody>




                        @foreach($cartItems as $item)

                        @php
                        // 🔥 UNIFIED VARIABLES
                        $productId = is_array($item) ? $item['id'] : $item->product->id;
                        $name = is_array($item) ? $item['name'] : $item->product->name;
                        $price = is_array($item) ? $item['price'] : $item->price;
                        $qty = is_array($item) ? $item['qty'] : $item->qty;
                        $image = is_array($item) ? $item['image'] : $item->product->image;
                        $stock = is_array($item) ? $item['stock'] : $item->product->stock;

                        $rowTotal = $price * $qty;
                        $subtotal += $rowTotal;
                        @endphp


                        <tr class="cart_item">
                            <td>
                                <a href="{{ route('product.show', is_array($item) ? $item['slug'] : $item->product->slug) }}">
                                    <img width="91" src="{{ asset('admin/images/products/'.$image) }}">
                                </a>
                            </td>

                            <td>
                                <a href="{{ route('product.show', is_array($item) ? $item['slug'] : $item->product->slug) }}">{{ $name }}</a>
                            </td>

                            <td>₹{{ $price }}</td>

                            <td>
                                <div class="quantity-box" data-id="{{ $productId }}">
                                    <button class="qty-minus" data-id="{{ $productId }}"
                                        {{ $qty <= 1 ? 'disabled' : '' }}>-</button>

                                    <input type="number" class="qty-input" data-id="{{ $productId }}" value="{{ $qty }}"
                                        min="1" max="{{ $stock }}">

                                    <button class="qty-plus" data-id="{{ $productId }}"
                                        {{ $qty >= $stock ? 'disabled' : '' }}>+</button>
                                </div>
                            </td>

                            <td>₹<span class="row-total" data-id="{{ $productId }}">{{ $rowTotal }}</span></td>

                            <td>
                                <span class="remove-cart" data-id="{{ $productId }}"
                                    style="cursor:pointer;color:red;">🗑</span>
                            </td>
                        </tr>

                        @endforeach
                        <tr>
                            <td colspan="6" class="actions">
                                <div class="th-cart-coupon">
                                    <input type="text" class="form-control" placeholder="Coupon Code..." />
                                    <button type="button" class="th-btn style2 style-radius">Apply Coupon</button>
                                </div>
                                <button type="button" class="th-btn style2 style-radius">Update cart</button>
                                <a href="shop.html" class="th-btn style3 style-radius">Continue Shopping</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <div class="row justify-content-end">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <h2 class="h4 summary-title">Cart Totals</h2>
                    <table class="cart_totals">
                        <tbody>
                            <tr>
                                <td>Cart Subtotal</td>
                                <td data-title="Cart Subtotal">
                                    <span class="amount"
                                        id="cart-subtotal"><bdi><span>₹</span>{{$subtotal}}</bdi></span>
                                </td>
                            </tr>
                            <tr class="shipping">
                                <th>Shipping and Handling</th>
                                <td data-title="Shipping and Handling">
                                    <ul class="woocommerce-shipping-methods list-unstyled">
                                        <li>
                                            <input type="radio" id="free_shipping" name="shipping_method"
                                                class="shipping_method" />
                                            <label for="free_shipping">Free shipping</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="flat_rate" name="shipping_method"
                                                class="shipping_method" checked="checked" />
                                            <label for="flat_rate">Flat rate</label>
                                        </li>
                                    </ul>
                                    <p class="woocommerce-shipping-destination">
                                        Shipping options will be updated during checkout.
                                    </p>
                                    <form action="javascript:void(0)" method="post">
                                        <a href="#" class="shipping-calculator-button">Change address</a>
                                        <div class="shipping-calculator-form">
                                            <p class="form-row">
                                                <select class="form-select">
                                                    <option value="AR">Argentina</option>
                                                    <option value="AM">Armenia</option>
                                                    <option value="BD" selected="selected">Bangladesh</option>
                                                </select>
                                            </p>
                                            <p>
                                                <select class="form-select">
                                                    <option value="">Select an option…</option>
                                                    <option value="BD-05">Bagerhat</option>
                                                    <option value="BD-01">Bandarban</option>
                                                    <option value="BD-02">Barguna</option>
                                                    <option value="BD-06">Barishal</option>
                                                </select>
                                            </p>
                                            <p class="form-row">
                                                <input type="text" class="form-control" placeholder="Town / City" />
                                            </p>
                                            <p class="form-row">
                                                <input type="text" class="form-control" placeholder="Postcode / ZIP" />
                                            </p>
                                            <p><button class="th-btn style2 style-radius">Update</button></p>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="order-total">
                                <td>Order Total</td>
                                <td data-title="Total">
                                    <strong><span class="amount"
                                            id="order-total"><bdi><span>$</span>{{$subtotal}}</bdi></span></strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                  <div class="wc-proceed-to-checkout mb-30">

    @if(count($cartItems) > 0)
        <form method="POST" action="{{ route('order.place') }}">
            @csrf
            <button type="submit" class="th-btn style2 style-radius w-100">
                Place Order
            </button>
        </form>
    @else
        <button class="th-btn style2 style-radius w-100" disabled>
            Cart is empty
        </button>
    @endif

</div>

                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
$(document).on('click', '.remove-cart', function() {
    let id = $(this).data('id');
    $.ajax({
        url: "{{route('cart.remove')}}",
        type: "POST",
        data: {
            _token: "{{csrf_token()}}",
            product_id: id
        },
        success: function(res) {
            location.reload();
        }
    });
});
    </script>


    <script>
function updateCartQty(productId, qty) {

    $.ajax({
        url: "{{ route('cart.update') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: productId,
            qty: qty
        },
        success: function(res) {

            if (!res.success) {
                alert(res.message);
                return;
            }

            // ✅ Row total update
            $('.row-total[data-id="' + res.productId + '"]').text(res.rowTotal);

            // ✅ Subtotal & Order total
            $('#cart-subtotal').text('₹' + res.subtotal);
            $('#order-total').text('₹' + res.subtotal);

            // ✅ Stock UI logic
            let input = $('.qty-input[data-id="' + res.productId + '"]');
            let plusBtn = $('.qty-plus[data-id="' + res.productId + '"]');
            let minusBtn = $('.qty-minus[data-id="' + res.productId + '"]');
            let stockText = $('#stock-text-' + res.productId);

            input.val(res.qty);
            input.attr('max', res.stock);

            if (res.qty >= res.stock) {
                plusBtn.prop('disabled', true);
                stockText.text('Out of stock').css('color', 'red');
            } else {
                plusBtn.prop('disabled', false);
                stockText.text('In stock').css('color', 'green');
            }

            minusBtn.prop('disabled', res.qty <= 1);
        }
    });
}
    </script>


    <script>
$(document).on('click', '.qty-plus', function() {

    let id = $(this).data('id');
    let input = $('.qty-input[data-id="' + id + '"]');
    let max = parseInt(input.attr('max'));
    let qty = parseInt(input.val());

    if (qty >= max) {
        alert('Out of stock');
        return;
    }

    updateCartQty(id, qty + 1);
});
    </script>


    <script>
$(document).on('click', '.qty-minus', function() {

    let id = $(this).data('id');
    let input = $('.qty-input[data-id="' + id + '"]');
    let qty = parseInt(input.val());

    if (qty <= 1) return;

    updateCartQty(id, qty - 1);
});
    </script>


    <script>
$(document).on('change', '.qty-input', function() {

    let id = $(this).data('id');
    let qty = parseInt($(this).val());
    let max = parseInt($(this).attr('max'));

    if (qty < 1) qty = 1;
    if (qty > max) {
        alert('Out of stock');
        qty = max;
    }

    updateCartQty(id, qty);
});
    </script>


    @endsection