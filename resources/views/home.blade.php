@extends('layouts.app')

@section('title', 'Home - Restaurant & Fast Food')

@section('content')

{{-- HERO SECTION --}}
{{-- HERO SECTION --}}

@if($hero)
<div class="th-hero-wrapper hero-1 bg-smoke" id="hero">
    <div class="hero-inner">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="hero-style1 text-center">

                        <span class="sub-title">
                            {{ $hero->sub_title }}
                        </span>

                        <h1 class="hero-title">
                            {{ $hero->title }}
                        </h1>

                        <div class="hero-img1">
<img src="{{ asset('storage/'.$hero->hero_image) }}?v={{ time() }}" alt="Hero Image">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif





{{-- CATEGORY SECTION --}}
<section class="space overflow-hidden space-extra-bottom">
    <div class="container">
        <div class="title-area text-center mb-60">
            <span class="sub-title text-anime-style-1">Category</span>
            <h2 class="sec-title text-anime-style-2">
                Browse Fast Foods <span class="text-theme">Category</span>
            </h2>
            <img class="img-anime-style-1" src="{{ asset('assets/img/icon/title-icon-5.png') }}" alt="img">
        </div>

        @if(isset($menuCategories) && $menuCategories->count())
        <div class="slider-area">
            <div class="swiper th-slider" id="catSlider1" data-slider-options='{
                    "autoplay": true,
                    "loop": true,
                    "breakpoints": {
                        "0": {"slidesPerView": 1},
                        "400": {"slidesPerView": 2},
                        "768": {"slidesPerView": 3},
                        "992": {"slidesPerView": 4},
                        "1200": {"slidesPerView": 5},
                        "1400": {"slidesPerView": 6}
                    }
                 }'>

                <div class="swiper-wrapper">

                    @foreach($menuCategories as $category)
                    <div class="swiper-slide">
                        <div class="category-card text-center">

                            {{-- Bottom Decoration --}}
                            <img class="cat-i-bottom" src="{{ asset('assets/img/icon/cat-1-bottom.png') }}" alt="img">

                            {{-- Category Image --}}
                            <div class="box-icon">
                                <a href="{{ route('categories.show', $category->slug) }}">
                                    <img src="{{ asset('admin/images/categories/'.$category->image) }}"
                                        alt="{{ $category->name }}">
                                </a>
                            </div>

                            {{-- Category Name --}}
                            <h3 class="box-title">
                                <a href="{{ route('categories.show', $category->slug) }}">
                                    {{ $category->name }}
                                </a>
                            </h3>

                            {{-- Product Count --}}
                            <p class="box-subtitle">
                                {{ $category->products_count }}
                                {{ $category->products_count == 1 ? 'Item' : 'Items' }} Available
                            </p>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        @else
        <div class="text-center">No categories available.</div>
        @endif
    </div>
</section>


{{-- ABOUT SECTION --}}

@if($about)
<section class="overflow-hidden space-bottom" id="about-sec">
    <div class="container">
        <div class="row align-items-center gy-40">

            <div class="col-xl-7">
                <img src="{{ asset('storage/'.$about->image) }}" class="img-fluid" alt="About">
            </div>

            <div class="col-xl-5">
                <span class="sub-title">{{ $about->small_title }}</span>

                <h2 class="sec-title">
                    {!! nl2br(e($about->title)) !!}
                </h2>

                <p>{{ $about->description }}</p>
            </div>

        </div>
    </div>
</section>
@endif


{{-- ================= FOOD MENU SECTION ================= --}}
<section class="food-sec-1 space overflow-hidden">
    <div class="container">

        {{-- TITLE --}}
        <div class="title-area text-center mb-50">
            <span class="sub-title">Our Fast Foods</span>
            <h2 class="sec-title">
                Our Delicious Fast <span class="text-theme">Foods</span>
            </h2>
        </div>

        {{-- CATEGORY TABS --}}
        <ul class="nav nav-tabs mt-4 mb-50">
            @foreach($menuCategories as $cat)
            <li class="nav-item">
                <button
                    class="nav-link th-btn btn-mask {{ $loop->first ? 'active' : '' }}"
                    onclick="loadProducts({{ $cat->id }}, this)">
                    {{ $cat->name }}
                </button>
            </li>
            @endforeach
        </ul>

        {{-- ✅ PRODUCTS WILL LOAD HERE --}}
        <div id="product-area">
            @include('partials.products-grid', [
                'products' => $menuCategories->first()->products()->paginate(8)
            ])
        </div>

    </div>
</section>

{{-- ================= END FOOD MENU SECTION ================= --}}





<div class="menu-sec1 space-top overflow-hidden" id="menu-sec">
    <div class="container">

        {{-- TITLE --}}
        <div class="title-area text-center mb-40">
            <span class="sub-title text-anime-style-1">Menu Card</span>
            <h2 class="sec-title text-anime-style-2">
                Our Fast Foods <span class="text-theme">Menu Card</span>
            </h2>
            <img class="img-anime-style-1" src="{{ asset('assets/img/icon/title-icon-5.png') }}" alt="img" />
        </div>

        <div class="row gy-4 justify-content-center">

            {{-- LEFT IMAGE --}}
            <div class="col-lg-3">
                <div class="menu-img-1-1 gsap-scroll-float-down2">
                    <img src="{{ asset('assets/img/menu/menu-1-1.jpg') }}" alt="img" />
                </div>
            </div>

            {{-- CENTER CONTENT --}}
            <div class="col-lg-6">
                <div class="menu-1-content-wrap ps-xl-3 pe-xl-5">

                    {{-- CATEGORY TABS --}}
                    <ul class="nav nav-tabs wow fadeinup" id="myTab" role="tablist">
                        @foreach($menuCategories as $key => $category)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $key == 0 ? 'active' : '' }}" id="tab-{{ $category->id }}"
                                data-bs-toggle="tab" data-bs-target="#cat-{{ $category->id }}" type="button" role="tab">
                                {{ strtoupper($category->name) }}
                            </button>
                        </li>
                        @endforeach
                    </ul>


                    {{-- TAB CONTENT --}}
                    <div class="tab-content" id="myTabContent">

                        @foreach($menuCategories as $key => $category)
                        <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="cat-{{ $category->id }}"
                            role="tabpanel">

                            @forelse($category->products as $index => $product)
                            <div class="menu-item-1 wow fadeinup" data-wow-delay=".{{ $index + 2 }}s">

                                <div class="thumb global-img"
                                    data-mask-src="{{ asset('assets/img/bg/menu-1-msk-bg.jpg') }}">
                                    <img src="{{ asset('admin/images/products/'.$product->image) }}"
                                        alt="{{ $product->name }}" />
                                </div>

                                <div class="content">
                                    <div class="left">
                                        <h3 class="box-title">
                                            <a href="{{ route('product.show', $product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        <p class="box-text">
                                            {{ $product->description ?? 'Fresh & delicious' }}
                                        </p>
                                    </div>

                                    <div class="right">
                                        <h4 class="price">
                                            <span>₹</span> {{ $product->price }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-center mt-4">No items available</p>
                            @endforelse

                        </div>
                        @endforeach

                    </div>

                </div>
            </div>

            {{-- RIGHT IMAGE --}}
            <div class="col-lg-3">
                <div class="menu-img-1-2 gsap-scroll-float-up">
                    <img src="{{ asset('assets/img/menu/menu-1-2.jpg') }}" alt="img" />
                </div>
            </div>

        </div>
    </div>
</div>



<section class="features-strip">
    <div class="container">
        <div class="features-row">

            <div class="feature-item">
                <img src="https://streetbitz.com/cdn/shop/files/Mesa_de_trabajo_1_copy_3.png?v=1709711524&width=100">
                <p>Authentic Taste</p>
            </div>

            <div class="feature-item">
                <img src="https://streetbitz.com/cdn/shop/files/LOGO-5_MIN_COOK_12956615-fdd1-449c-a76c-924f1ce5f6f0.png?v=1710246973&width=100">
                <p>5 minute cooking time</p>
            </div>

            <div class="feature-item">
                <img src="https://streetbitz.com/cdn/shop/files/100_natural_8e08c35e-ee08-4d55-9730-78775398aeb7.png?v=1712749932&width=100">
                <p>No Preservatives</p>
            </div>

            <div class="feature-item">
                <img src="https://streetbitz.com/cdn/shop/files/Artboard_512.png?v=1709711525&width=100">
                <p>Same Day Delivery if ordered before 3pm</p>
            </div>

        </div>
    </div>
</section>


 
    


<section class="testi-area-1 space-bottom overflow-hidden" id="testi-sec">
    <!-- SHAPES SAME -->
    <div class="shape-mockup d-none d-xxl-block jump-reverse" style="top: 2%; left: 0%">
        <img src="{{ asset('assets/img/icon/hero-1-3.png') }}" alt="img" />
    </div>
    <div class="shape-mockup d-none d-xxl-block jump" style="top: 10%; right: 0%">
        <img src="{{ asset('assets/img/icon/testi-top-1-1.png') }}" alt="img" />
    </div>
    <div class="shape-mockup d-none d-xxl-block jump" style="bottom: 2%; left: 0%">
        <img src="{{ asset('assets/img/icon/testi-top-1-2.png') }}" alt="img" />
    </div>

    <div class="container">
        <!-- TITLE SAME -->
        <div class="title-area text-center mb-60">
            <span class="sub-title text-anime-style-1">Testimonials</span>
            <h2 class="sec-title text-anime-style-2">
                Our Customers <span class="text-theme">Feedback</span>
            </h2>
            <img class="img-anime-style-1"
                 src="{{ asset('assets/img/icon/title-icon-5.png') }}" alt="img" />
        </div>

        <!-- DYNAMIC CONTENT -->
        <div class="row gy-40 gx-30">
            @foreach($testimonials as $index => $t)
                <div class="col-xl-6">
                    <div class="testi-1-item wow {{ $index % 2 == 0 ? 'fadeinleft' : 'fadeinright' }}"
                         data-wow-delay=".3s">

                        <div class="client-thumb">
                            <img src="{{ $t->image
                                ? asset('storage/'.$t->image)
                                : asset('assets/img/testimonial/default.png') }}"
                                alt="img" />
                        </div>

                        <div class="content">
                            <img class="testi-1-quote"
                                 src="{{ asset('assets/img/icon/testi-1-quote.png') }}"
                                 alt="icon" />
                            <p class="box-text">“{{ $t->message }}”</p>
                        </div>

                        <div class="bottom">
                            <h4 class="box-title">{{ $t->name }}</h4>
                            @if($t->company)
                                <p>{{ $t->company }}</p>
                            @endif

                            <div class="th-social">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $t->rating ? '' : 'opacity-25' }}"></i>
                                @endfor
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>





<section class="cta-area-1 bg-theme4 overflow-hidden">
    <div class="shape-mockup footer-bg-shape1-1 jump d-none d-xl-block" data-left="0" data-top="5%">
        <img src="{{asset('assets/img/icon/cta-1-top.png')}}" alt="img" />
    </div>
    <img class="round-shape-top" src="{{asset('assets/img/shape/shape-top-smoke.png')}}" alt="img" />
    <div class="cta-bg-1-1-wrap">
        <div class="cta-bg-1-1"><img src="{{asset('assets/img/bg/cta-bg-1-1.png')}}" alt="img" /></div>
    </div>
    <div class="cta-1-shape-trangle"></div>
    <div class="cta-round-shape"></div>
    <div class="container z-index-common">
        <div class="row gy-30">
            <div class="col-xl-6 col-lg-6">
                <div class="cta-wrap1">
                    <div class="title-area me-xl-5 pe-xl-5 mb-0">
                        <h2 class="sec-title text-anime-style-1 text-white">
                            Subscribe to our newsletter
                            <span class="text-theme">Fast Food Order</span>
                        </h2>
                        <p class="sec-text text-anime-style-2 text-title mt-30 mb-20 fw-medium">
                            Get all latest information on sales and offer
                        </p>
                        <form class="newsletter-form img-anime-style-1">
                            <div class="form-group">
                                <input class="form-control" type="email" placeholder="Enter your mail address...."
                                    required="" />
                            </div>
                            <button type="submit" class="th-btn style4 mt-0">SUBSCRIBE</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 align-self-end">
                <div class="cta-thumb1-1 text-center text-lg-end tilt-active wow fadeiright">
                    <img src="{{asset('assets/img/cta/cta-1-img.png')}}" alt="img" />
                </div>
            </div>
        </div>
    </div>
</section>



@endsection