@extends('layouts.app')

@section('title', 'My Orders')

@section('content')

<div class="container space-top space-extra-bottom">

    <h2 class="mb-4">My Orders</h2>

    @if($orders->count() === 0)
        <p>You have not placed any orders yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>₹{{ $order->total }}</td>
                    <td>
                        <span class="badge bg-success">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}"
                           class="btn btn-sm btn-primary">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>

@endsection
