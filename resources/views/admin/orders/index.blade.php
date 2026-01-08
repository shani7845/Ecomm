@extends('admin.layouts.app')

@section('content')

<div class="main-content">
    <div class="main-content-inner">
        <div class="main-content-wrap">

            {{-- PAGE TITLE --}}
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Order List</h3>
                <ul class="breadcrumbs flex items-center gap10">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Orders</div></li>
                </ul>
            </div>

            {{-- ORDER LIST --}}
            <div class="wg-box">

                <div class="wg-table table-all-category">

                    {{-- TABLE HEAD --}}
                    <ul class="table-title flex gap20 mb-14">
                        <li><div class="body-title">Order ID</div></li>
                        <li><div class="body-title">Total</div></li>
                        <li><div class="body-title">Items</div></li>
                        <li><div class="body-title">Payment</div></li>
                        <li><div class="body-title">Status</div></li>
                        <li><div class="body-title">Date</div></li>
                        <li><div class="body-title">Action</div></li>
                    </ul>

                    {{-- TABLE BODY --}}
                    <ul class="flex flex-column">

                        @forelse($orders as $order)
                        <li class="product-item gap14">

                            <div class="flex items-center justify-between gap20 flex-grow">

                                <div class="body-text">
                                    #{{ $order->id }}
                                </div>

                                <div class="body-text">
                                    ₹{{ $order->total }}
                                </div>

                                <div class="body-text">
                                    {{ $order->items->sum('qty') }}
                                </div>

                                <div class="body-text">
                                    COD
                                </div>

                                {{-- STATUS --}}
                                <div>
                                    @if($order->status === 'completed')
                                        <div class="block-available">Completed</div>
                                    @elseif($order->status === 'confirmed')
                                        <div class="block-success">Confirmed</div>
                                    @elseif($order->status === 'cancelled')
                                        <div class="block-not-available">Cancelled</div>
                                    @else
                                        <div class="block-pending">Pending</div>
                                    @endif
                                </div>

                                <div class="body-text">
                                    {{ $order->created_at->format('d M Y') }}
                                </div>

                                {{-- ACTION --}}
                                <div class="list-icon-function">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="item eye">
                                        <i class="icon-eye"></i>
                                    </a>
                                </div>

                            </div>
                        </li>
                        @empty
                        <li class="product-item">
                            <div class="body-text text-center w-full">
                                No orders found
                            </div>
                        </li>
                        @endforelse

                    </ul>
                </div>

                {{-- PAGINATION --}}
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10">
                    <div class="text-tiny">
                        Showing {{ $orders->count() }} orders
                    </div>

                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
