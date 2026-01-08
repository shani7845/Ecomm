@extends('layouts.app')

@section('content')
<section class="product-details space-top space-extra-bottom">
    <div class="container">
        <div class="row gx-60">

            <!-- PRODUCT IMAGE -->
            <div class="col-lg-6">
                <div class="product-big-img">
                    <div class="food-mask" data-mask-src="assets/img/bg/menu-1-msk-bg.png"></div>
                    <div class="img">
                        <img src="{{ $product->image ? asset('admin/images/products/'.$product->image) : asset('admin/images/no-image.png') }}"
                            alt="Product Image">
                    </div>
                </div>
            </div>

            <!-- PRODUCT DETAILS -->
            <div class="col-lg-6 align-self-center">
                <div class="product-about">
                    <h2 class="product-title">{{ $product->name }}</h2>

                    <p class="text pe-xl-5">
                        {{ $product->description }}
                    </p>

                    <p class="price">₹{{ $product->price }}</p>

<div class="mt-2">
    <strong>Availability:</strong>

    @if($product->stock <= 0)
        <span class="stock out-of-stock text-danger">
            ❌ Out of Stock
        </span>
    @elseif($product->stock <= 5)
        <span class="stock low-stock text-warning">
            ⚠ Only {{ $product->stock }} left
        </span>
    @else
        <span class="stock in-stock text-success">
            ✅ In Stock
        </span>
    @endif
</div>


                    <!-- QTY + ADD TO CART -->
                    <div class="actions mt-3">
                         @if($product->stock > 0)
                        <div class="quantity">
                            <button type="button" class="quantity-minus qty-btn">-</button>

                            <input type="number" class="qty-input" min="1" max="{{ $product->stock }}" value="1">

                         <button type="button"
                         class="quantity-plus qty-btn">
                            +
                                            </button>

                        </div>

                       <button id="addToCartBtn"
        class="th-btn style2 add-to-cart-btn"
        data-product-id="{{ $product->id }}"
        data-stock="{{ $product->stock }}">
    Add to Cart
</button>

@else
     {{-- OUT OF STOCK --}}
        <button class="th-btn style2"
                disabled
                style="background:#ccc;cursor:not-allowed;">
            Out of Stock
        </button>

    @endif
                   </div>

                    <div class="product_meta mt-3">
                        <span>
                            Category:
                            <strong>{{ $product->category->name }}</strong>
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<script src="{{ asset('assets/js/vendor/jquery-3.7.1.min.js') }}"></script>



{{-- ADD TO CART SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // helper: update plus/minus enabled state
    function updateQtyButtons() {
        let input = document.querySelector('.qty-input');
        if (!input) return;
        let max = parseInt(input.getAttribute('max')) || Infinity;
        let val = parseInt(input.value) || 0;

        let plus = document.querySelector('.quantity-plus');
        if (plus) {
            plus.disabled = val >= max;
        }

        let minus = document.querySelector('.quantity-minus');
        if (minus) {
            // keep minus always enabled (don't auto-disable at 1)
            minus.disabled = false;
        }
    }

    // enable/disable Add to Cart based on stock and qty
    function updateAddToCartButton() {
        let btn = document.getElementById('addToCartBtn');
        if (!btn) return;
        let stock = parseInt(btn.dataset.stock) || 0;
        let input = document.querySelector('.qty-input');
        let qty = input ? (parseInt(input.value) || 0) : 0;

        // disable when no stock or requested qty is equal/above stock
        btn.disabled = stock <= 0 || qty >= stock;
    }

    // update availability badge text + styling
    function updateAvailabilityLabel() {
        let btn = document.getElementById('addToCartBtn');
        let stock = btn ? (parseInt(btn.dataset.stock) || 0) : 0;
        let input = document.querySelector('.qty-input');
        let qty = input ? (parseInt(input.value) || 0) : 0;
        let span = document.querySelector('.stock');
        if (!span) return;

        // if total stock is zero OR user selected qty reached total stock -> treat as out of stock
        if (stock <= 0 || qty >= stock) {
            span.className = 'stock out-of-stock text-danger';
            span.innerHTML = '❌ Out of Stock';
            return;
        }

        // low stock
        if (stock <= 5) {
            span.className = 'stock low-stock text-warning';
            span.innerHTML = '⚠ Only ' + stock + ' left';
            return;
        }

        // default in stock
        span.className = 'stock in-stock text-success';
        span.innerHTML = '✅ In Stock';
    }

    // initialize state on load
    updateQtyButtons();
    updateAddToCartButton();
    updateAvailabilityLabel();

    // update when user edits quantity directly
    let qtyInputEl = document.querySelector('.qty-input');
    if (qtyInputEl) {
        qtyInputEl.addEventListener('input', function () {
            // clamp value between min and max
            let min = parseInt(qtyInputEl.getAttribute('min')) || 1;
            let max = parseInt(qtyInputEl.getAttribute('max')) || Infinity;
            let v = parseInt(qtyInputEl.value) || min;
            if (v < min) v = min;
            if (v > max) v = max;
            qtyInputEl.value = v;
            updateQtyButtons();
            updateAddToCartButton();
        });
    }

    // handle plus/minus clicks
    document.addEventListener('click', function (e) {
        // PLUS BUTTON
        if (e.target.classList.contains('quantity-plus')) {
            let input = document.querySelector('.qty-input');
            if (!input) return;
            let max = parseInt(input.getAttribute('max')) || Infinity;
            let val = parseInt(input.value) || 0;

            if (val >= max) {
                alert('Only ' + max + ' left in stock');
                updateQtyButtons();
                updateAddToCartButton();
                updateAvailabilityLabel();
                return;
            }

            input.value = val + 1;
            updateQtyButtons();
            updateAddToCartButton();
            updateAvailabilityLabel();
        }

        // MINUS BUTTON
        if (e.target.classList.contains('quantity-minus')) {
            let input = document.querySelector('.qty-input');
            if (!input) return;
            let val = parseInt(input.value) || 0;

            if (val > 1) {
                input.value = val - 1;
            }

            updateQtyButtons();
            updateAddToCartButton();
            updateAvailabilityLabel();
        }
    });

});
</script>




<script>
document.addEventListener('click', function (e) {

    if (e.target.id !== 'addToCartBtn') return;

    let productId = e.target.dataset.productId;
    let stock = parseInt(e.target.dataset.stock);
    let qty = parseInt(document.querySelector('.qty-input').value);

    // FRONTEND SAFETY
    if (stock <= 0) {
        alert('This product is out of stock');
        return;
    }

    if (qty >= stock) {
        alert('Only ' + stock + ' left in stock');
        return;
    }

    fetch("{{ route('cart.add') }}", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
            "X-GUEST-TOKEN": localStorage.getItem('guest_token')
        },
        body: JSON.stringify({
            product_id: productId,
            qty: qty
        })
    })
    .then(res => res.json())
    .then(res => {

        if (!res.success) {
            alert(res.message ?? 'Failed');
            return;
        }

        // save guest token if returned
        if (res.guest_token) {
            localStorage.setItem('guest_token', res.guest_token);
            document.cookie =
                'guest_token=' + res.guest_token +
                '; path=/; max-age=' + (60*60*24*30);
        }

        // update cart count
        document.querySelectorAll('.cart-count')
            .forEach(el => el.innerText = res.count);

        // update side cart
        if (res.side_cart_html) {
            document.getElementById('side-cart-content').innerHTML =
                res.side_cart_html;
        }

        alert('Added to cart');
    })
    .catch(() => alert('Server error'));
});
</script>



@endsection