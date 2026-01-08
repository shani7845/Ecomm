<div class="row gy-40">
    @forelse($products as $index => $product)
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="food-card-1 style-2 wow fadeinup" data-wow-delay=".{{ $index + 1 }}s">

            <div class="thumb">
                <div class="food-mask"
                     data-mask-src="{{ asset('assets/img/bg/menu-1-msk-bg.png') }}"></div>

                <img src="{{ asset('admin/images/products/'.$product->image) }}" alt="{{ $product->name }}">

                <div class="actions">
                    <a href="javascript:void(0)" class="icon-btn">
                        <i class="far fa-cart-plus"></i>
                    </a>
                </div>
            </div>

            <div class="content">
                <h4 class="price">₹{{ $product->price }}</h4>
                <h4 class="box-title">{{ $product->name }}</h4>
                <p class="box-text">
                    {{ \Illuminate\Support\Str::limit($product->description, 80) }}
                </p>
            </div>
        </div>
    </div>
    @empty
        <p class="text-center">No products found</p>
    @endforelse
</div>

<div class="th-pagination d-flex justify-content-center pt-50">
    {{ $products->links() }}
</div>
