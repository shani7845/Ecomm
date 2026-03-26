@extends('layouts.app')
@section('content')

<section class="space-top space-extra2-bottom">
    <div class="container">
        <div class="th-sort-bar">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">

                    <p class="woocommerce-result-count">
                        Showing {{ $products->firstItem() }} – {{ $products->lastItem() }}
                        of {{ $products->total() }} products
                    </p>

                </div>
                <!-- <div class="col-md-auto">
                    <form class="woocommerce-ordering" method="get">
                        <select name="orderby" class="orderby" aria-label="Shop order">
                            <option value="menu_order" selected="selected">Default Sorting</option>
                            <option value="popularity">Sort by popularity</option>
                            <option value="rating">Sort by average rating</option>
                            <option value="date">Sort by latest</option>
                            <option value="price">Sort by price: low to high</option>
                            <option value="price-desc">Sort by price: high to low</option>
                        </select>
                    </form>
                </div> -->
            </div>
        </div>
        <div class="row gy-40 gx-30">

            @forelse($products as $product)
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="th-product product-grid">
                    <div class="product-img">
                        <div class="food-mask" data-mask-src="{{ asset('assets/img/bg/menu-1-msk-bg.png') }}"></div>

                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" />

                        <div class="actions">
                            <a href="{{ route('product.show', $product->slug) }}" class="icon-btn"><i
                                    class="far fa-eye"></i></a>
                            <a href="#" class="icon-btn"><i class="far fa-cart-plus"></i></a>
                            <a href="#" class="icon-btn"><i class="far fa-heart"></i></a>
                        </div>
                    </div>

                    <div class="product-content">
                        <h3 class="product-title">
                            <a href="{{ route('product.show', $product->slug) }}">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <span class="price">₹{{ $product->price }}</span>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center">No products found</p>
            @endforelse

        </div>
        @if ($products->hasPages())
        <div class="th-pagination d-flex justify-content-center pt-50">
            {{ $products->links() }}
        </div>
        @endif


    </div>
</section>




@endsection