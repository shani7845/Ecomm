@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

{{-- BREADCRUMB --}}
<div class="breadcumb-wrapper overflow-hidden" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">Checkout</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CHECKOUT --}}
<div class="th-checkout-wrapper space-top space-extra-bottom">
    <div class="container">

        <form method="POST" action="{{ route('order.confirm', $order->id) }}">
            @csrf

            <div class="row">

                {{-- =========================
                    BILLING DETAILS
                ========================= --}}
                <div class="col-lg-6">
    <h4 class="mb-3">Billing Details</h4>

    <div class="row">
        <div class="col-md-6 mb-3">
            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
        </div>

        <div class="col-md-6 mb-3">
            <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
        </div>

        <div class="col-12 mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
        </div>

        <div class="col-12 mb-3">
            <textarea name="address" class="form-control" rows="3"
                placeholder="Full Address" required></textarea>
        </div>

        <div class="col-md-6 mb-3">
            <input type="text" name="city" class="form-control" placeholder="City">
        </div>

        <div class="col-md-6 mb-3">
            <input type="text" name="pincode" class="form-control" placeholder="Pincode / ZIP">
        </div>
    </div>
</div>


                {{-- =========================
                    ORDER SUMMARY
                ========================= --}}
                <div class="col-lg-6">
                    <h4 class="mb-3">Your Order</h4>

                    <table class="cart_table mb-20">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    {{ $item->product->name }}
                                    <strong> × {{ $item->qty }}</strong>
                                </td>
                                <td class="text-end">
                                    ₹{{ $item->qty * $item->price }}
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Subtotal</th>
                                <th class="text-end">₹{{ $order->total }}</th>
                            </tr>
                            <tr>
                                <th>Shipping</th>
                                <th class="text-end">Free</th>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th class="text-end">
                                    <strong>₹{{ $order->total }}</strong>
                                </th>
                            </tr>
                        </tfoot>
                    </table>

                    {{-- =========================
                        PAYMENT METHOD
                    ========================= --}}
                    <div class="woocommerce-checkout-payment">
                        <h5 class="mb-2">Payment Method</h5>

                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                   type="radio"
                                   name="payment_method"
                                   value="cod"
                                   checked>
                            <label class="form-check-label">
                                Cash on Delivery (COD)
                            </label>
                        </div>

                        <p class="small text-muted">
                            Pay with cash upon delivery.
                        </p>

                        <button type="submit"
                                class="th-btn style2 w-100 mt-3">
                            Confirm Order
                        </button>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>

@endsection
