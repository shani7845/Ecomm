@extends('layouts.app')

@section('title', 'Order Details')

@section('content')

<div class="container space-top space-extra-bottom">

    <h3 class="mb-3">Order #{{ $order->id }}</h3>

    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Total:</strong> ₹{{ $order->total }}</p>

    <hr>

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

    <hr>

    <h5>Ordered Items</h5>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->qty }}</td>
                <td>₹{{ $item->price }}</td>
                <td>₹{{ $item->qty * $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.my') }}" class="th-btn style2 mt-3">
        Back to Orders
    </a>

</div>

@endsection
