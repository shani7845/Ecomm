{{-- PRELOADER --}}
<div class="preloader">
    <button class="th-btn preloaderCls">Cancel Preloader</button>
    <div id="preloader" class="preloader-inner">
        <div class="header-logo pb-2">
            <a href="{{ url('/') }}">
                <img class="jump" src="{{ asset('assets/img/logo.jpg') }}" alt="Scooble">
            </a>
        </div>
        <div class="txt-loading">
            @foreach(str_split('SCOOBLE') as $char)
                <span data-text-preloader="{{ $char }}" class="letters-loading">{{ $char }}</span>
            @endforeach
        </div>
    </div>
</div>

{{-- SIDE CART --}}
<div class="sidemenu-wrapper sidemenu-cart">
    <div class="sidemenu-content">
        <button class="closeButton sideMenuCls">
            <i class="far fa-times"></i>
        </button>
        <div class="widget woocommerce widget_shopping_cart">
            <h3 class="widget_title">Shopping cart</h3>
            <div id="side-cart-content">
                @include('partials.side-cart')
            </div>
        </div>
    </div>
</div>

{{-- HEADER --}}
<header class="th-header header-default">

    {{-- TOP BAR --}}
    <div class="header-top d-sm-block d-none">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <ul class="header-links">
                        <li><i class="far fa-location-dot"></i> Rithala, Rohini, Delhi-110085</li>
                        <li><i class="far fa-envelope-open"></i> info@wowscooble.com</li>
                        <li><i class="far fa-clock"></i> Mon to Sat - 9am to 5pm</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="th-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN MENU --}}
    <div class="sticky-wrapper">
        <div class="menu-area">
            <div class="container">
                <div class="row align-items-center justify-content-between">

                    {{-- LOGO --}}
                    <div class="col-auto">
                        <div class="header-logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/img/logo.jpg') }}" alt="Scooble" width="130">
                            </a>
                        </div>
                    </div>

                    {{-- CATEGORY MENU --}}
                    <div class="col d-none d-lg-block">
                        <nav class="main-menu">
                            <ul class="category-menu">
                                @foreach($menuCategories as $category)
                                    <li class="{{ $category->products->count() ? 'menu-item-has-children' : '' }}">
                                        <a href="{{ route('categories.show', $category->slug) }}">
                                            {{ strtoupper($category->name) }}
                                        </a>

                                        @if($category->products->count())
                                            <ul class="sub-menu">
                                                @foreach($category->products as $product)
                                                    <li>
                                                        <a href="{{ route('product.show', $product->slug) }}">
                                                            {{ $product->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>

                    {{-- RIGHT ICONS --}}
                    <div class="col-auto d-flex align-items-center gap-3">

                        {{-- SEARCH ICON (CLIENT STYLE) --}}
                        <button type="button" class="icon-btn searchBoxToggler">
                            <i class="far fa-search"></i>
                        </button>

                        {{-- ACCOUNT --}}
                        <nav class="account-nav d-none d-lg-block">
                            <ul class="account-menu">
                                @auth
                                    <li class="menu-item-has-children">
                                        <a href="#">Hi, {{ Str::limit(Auth::user()->name, 8) }}</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                                            <li><a href="{{ route('orders.my') }}">My Orders</a></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="logout-btn">Logout</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @else
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                @endauth
                            </ul>
                        </nav>

                        {{-- CART --}}
                        <button type="button" class="icon-btn sideMenuToggler">
                            <span class="badge cart-count">{{ $cartCount }}</span>
                            <i class="fa-regular fa-cart-shopping"></i>
                        </button>

                        {{-- MOBILE MENU --}}
                        <button type="button" class="icon-btn th-menu-toggle d-lg-none">
                            <i class="far fa-bars"></i>
                        </button>

                    </div>

                </div>
            </div>
        </div>
    </div>

</header>

{{-- SEARCH POPUP (CLIENT STYLE) --}}
<div class="popup-search-box">
    <button class="searchClose">
        <i class="fas fa-times"></i>
    </button>

    <form action="{{ route('products.search') }}" method="GET">
    <input type="text"
       id="live-search-input"
       name="q"
       placeholder="Search food..."
       value="{{ request('q') }}"
       autocomplete="off"
       autofocus>

               
        <button type="submit">
            <i class="far fa-search"></i>
        </button>
    </form>
    <div id="live-search-results" class="live-search-results"></div>
</div>
