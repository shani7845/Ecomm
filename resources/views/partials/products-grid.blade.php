<div class="row gy-40">
    @forelse($products as $index => $product)
    <div class="col-xl-3 col-lg-6 col-md-6">
        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
            <div class="food-card-1 style-2 wow fadeinup" data-wow-delay=".{{ $index + 1 }}s" style="cursor: pointer;">

                <div class="thumb">
                    <div class="food-mask"
                         data-mask-src="{{ asset('assets/img/bg/menu-1-msk-bg.png') }}"></div>

                    <img src="{{ asset('admin/images/products/'.$product->image) }}" alt="{{ $product->name }}">

                    <div class="actions">
                        @if($product->stock > 0)
                            <button type="button" class="icon-btn" onclick="addToCart({{ $product->id }}, this); event.preventDefault();">
                                <i class="far fa-cart-plus"></i>
                            </button>
                        @else
                            <button type="button" class="icon-btn disabled" disabled title="Out of stock" aria-disabled="true" data-bs-toggle="tooltip">
                                <i class="fas fa-ban"></i>
                            </button>
                        @endif
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
        </a>
    </div>
    @empty
        <p class="text-center">No products found</p>
    @endforelse
</div>

<div class="th-pagination d-flex justify-content-center pt-50">
    {{ $products->links() }}
</div>
