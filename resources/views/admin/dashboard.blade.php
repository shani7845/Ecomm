@extends('admin.layouts.app')

@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">

        {{-- TOP CARDS --}}
        @include('admin.dashboard.cards')

        {{-- RECENT ORDER + TOP PRODUCTS + TOP COUNTRIES --}}
        <div class="tf-section-5 mb-30">
            @include('admin.dashboard.recent-orders')
            @include('admin.dashboard.top-products')
        </div>

        {{-- BEST SELLERS + PRODUCT OVERVIEW --}}
        <div class="tf-section-6 mb-30">
            @include('admin.dashboard.best-sellers')
            @include('admin.dashboard.product-overview')
        </div>

        {{-- ORDERS + EARNINGS + COMMENTS --}}
        <div class="tf-section-3">
            @include('admin.dashboard.orders')
            @include('admin.dashboard.earnings')
        </div>

    </div>
</div>

@endsection