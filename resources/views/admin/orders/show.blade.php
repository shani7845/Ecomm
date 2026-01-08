@extends('admin.layouts.app')

@section('content')

<h3>Order #{{ $order->id }}</h3>

<p><strong>Total:</strong> ₹{{ $order->total }}</p>
<p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

<form method="POST" action="{{ route('admin.orders.status', $order->id) }}">
    @csrf
    @method('PATCH')

    <select name="status" class="form-select w-25 mb-2">
        <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
        <option value="confirmed" {{ $order->status=='confirmed'?'selected':'' }}>Confirmed</option>
        <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Completed</option>
        <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
    </select>

    <button class="btn btn-success btn-sm">Update Status</button>
</form>

<hr>

<h4>Items</h4>
<ul>
@foreach($order->items as $item)
    <li>
        {{ $item->product->name }} × {{ $item->qty }}
        (₹{{ $item->price }})
    </li>
@endforeach
</ul>

@endsection
