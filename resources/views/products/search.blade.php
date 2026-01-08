@extends('layouts.app')

@section('content')
<section class="space-top space-extra2-bottom">
    <div class="container">

        {{-- 🔹 SORT BAR --}}
        <div class="th-sort-bar">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">
                    <p class="woocommerce-result-count">
                        Showing {{ $products->firstItem() ?? 0 }}
                        – {{ $products->lastItem() ?? 0 }}
                        of {{ $products->total() }} results
                    </p>
                </div>
            </div>
        </div>

        {{-- 🔹 PRODUCTS GRID --}}
        <div class="row gy-40 gx-30">

            @forelse($products as $product)
                <div class="col-xl-3 col-lg-4 col-sm-6">

                    <div class="th-product product-grid">

                        <div class="product-img">
                            <div class="food-mask"
                                 data-mask-src="{{ asset('assets/img/bg/menu-1-msk-bg.png') }}">
                            </div>

                            <img src="{{ asset('admin/images/products/'.$product->image) }}"
                                 alt="{{ $product->name }}">

                            <div class="actions">
                                <a href="{{ route('product.show', $product->slug) }}"
                                   class="icon-btn">
                                    <i class="far fa-eye"></i>
                                </a>

                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button class="icon-btn" type="submit">
                                        <i class="far fa-cart-plus"></i>
                                    </button>
                                </form>
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
                <div class="col-12 text-center">
                    <p>No products found.</p>
                </div>
            @endforelse

        </div>

        {{-- 🔹 PAGINATION --}}
        <div class="th-pagination d-flex justify-content-center pt-50">
            {{ $products->links() }}
        </div>

    </div>
</section>

@endsection
