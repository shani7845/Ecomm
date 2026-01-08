@extends('layouts.app')

@section('title', 'Order Success')

@section('content')

<div class="container space-top space-extra-bottom">

    <div class="text-center mb-4">
        <h2 class="text-success">🎉 Order Placed Successfully!</h2>
        <p>Thank you for your order.</p>
    </div>

    <div class="card p-4 mb-4">
        <h5>Order Details</h5>
        <p><strong>Order ID:</strong> #{{ $order->id }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Total:</strong> ₹{{ $order->total }}</p>
        <p><strong>Payment Method:</strong> Cash on Delivery</p>
    </div>

    <div class="card p-4 mb-4">
        <h5>Billing Address</h5>

        @php
            $billing = $order->addresses->where('type','billing')->first();
        @endphp

        @if($billing)
            <p>{{ $billing->name }}</p>
            <p>{{ $billing->phone }}</p>
            <p>{{ $billing->email }}</p>
            <p>{{ $billing->address }}</p>
        @endif
    </div>

    <div class="card p-4 mb-4">
        <h5>Items Ordered</h5>

        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>₹{{ $item->qty * $item->price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-center">
        <a href="{{ route('home') }}" class="th-btn style2">
            Continue Shopping
        </a>
    </div>

</div>

@endsection
