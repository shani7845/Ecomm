<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    <title>@yield('title', 'Restaurant')</title>

    <meta name="viewport" content="width=device-width,initial-scale=1" />

    <!-- CSS -->
       <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Bangers&amp;family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Dynalight&amp;family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&amp;family=Jost:ital,wght@0,100..900;1,100..900&amp;family=Bevan:ital@0;1&amp;display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- @vite(['resources/js/app.js']) -->
    <link rel="stylesheet" href="{{ asset('assets/css/live-search.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

    <style>
    /* Skeleton loader styles */
    .skeleton { display: block; background: linear-gradient(90deg,#f0f0f0 25%,#e6e6e6 37%,#f0f0f0 63%); background-size: 400% 100%; animation: shimmer 1.2s linear infinite; border-radius:4px; }
    @keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
    .skeleton-img{ width:100%; height:180px; display:block; border-radius:8px; }
    .skeleton-title{ width:60%; height:18px; margin:12px 0; }
    .skeleton-sub{ width:40%; height:14px; margin-bottom:8px; }
    .skeleton-text{ width:100%; height:12px; margin:6px 0; }
    /* disabled icon button for out-of-stock */
    .icon-btn.disabled{ opacity:0.6; cursor:not-allowed; }
    </style>


</head>

<body>

    {{-- HEADER --}}
    @include('layouts.header')

    {{-- PAGE CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    @include('layouts.footer')

    <!-- JS -->
    <script src="{{ asset('assets/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/clean_no_inspect_block.js') }}"></script> -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/lenis.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/live-search.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
var swiper = new Swiper(".testiSwiper", {
    loop: true,
    spaceBetween: 30,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        0: {
            slidesPerView: 1,   // Mobile
        },
        768: {
            slidesPerView: 1,   // Tablet
        },
        1200: {
            slidesPerView: 2,   // Desktop
        }
    }
});
</script>


    <script>
function renderSkeletons(count){
    var html = '<div class="row gy-40">';
    for(var i=0;i<count;i++){
        html += `
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="food-card-1 style-2">
                <div class="thumb">
                    <span class="skeleton skeleton-img"></span>
                </div>
                <div class="content">
                    <span class="skeleton skeleton-title"></span>
                    <span class="skeleton skeleton-sub"></span>
                    <span class="skeleton skeleton-text"></span>
                    <span class="skeleton skeleton-text" style="width:80%;"></span>
                </div>
            </div>
        </div>`;
    }
    html += '</div>';
    html += '<div class="th-pagination d-flex justify-content-center pt-50"><!-- skeleton pagination --></div>';
    return html;
}

function loadProducts(categoryId, el) {

    // active tab highlight
    document.querySelectorAll('.nav-link').forEach(btn => btn.classList.remove('active'));
    el.classList.add('active');

    // show skeletons while loading
    document.getElementById('product-area').innerHTML = renderSkeletons(8);

    fetch(`{{ route('ajax.products') }}?category_id=` + categoryId)
        .then(res => res.text())
        .then(html => {
            document.getElementById('product-area').innerHTML = html;
            initTooltips();
        })
        .catch(() => {
            // restore a friendly message on error
            document.getElementById('product-area').innerHTML = '<p class="text-center">Failed to load products.</p>';
        });
}

// Pagination AJAX with skeletons
document.addEventListener('click', function(e){
    var a = e.target.closest('.pagination a');
    if(a){
        e.preventDefault();
        document.getElementById('product-area').innerHTML = renderSkeletons(8);
        fetch(a.href)
            .then(res => res.text())
            .then(html => {
                document.getElementById('product-area').innerHTML = html;
                initTooltips();
            })
            .catch(()=>{
                document.getElementById('product-area').innerHTML = '<p class="text-center">Failed to load products.</p>';
            });
    }
});
</script>


    <script>
    function removeItem(id) {
        alert("call removeITEM")
        fetch("{{ route('cart.remove') }}", {
                method: "POST",
                credentials: 'same-origin',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                    "X-GUEST-TOKEN": localStorage.getItem('guest_token')
                },
                body: JSON.stringify({
                    product_id: id
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    // update cart-count badges
                    document.querySelectorAll('.cart-count').forEach(el => el.innerText = res.count);

                    // update side cart HTML if returned
                    if (res.side_cart_html) {
                        document.getElementById('side-cart-content').innerHTML = res.side_cart_html;
                    }

                    location.reload(); // TEMP
                }
            });
    }
    </script>

    <script>
    function addToCart(productId, el){
        // simple UI feedback
        var orig = el.innerHTML;
        el.disabled = true;
        el.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

        fetch("{{ route('cart.add') }}", {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Content-Type': 'application/json',
                'X-GUEST-TOKEN': localStorage.getItem('guest_token')
            },
            body: JSON.stringify({ product_id: productId, qty: 1 })
        })
        .then(res => res.json())
        .then(res => {
            if(res.success){
                // update cart-count badges
                document.querySelectorAll('.cart-count').forEach(el => el.innerText = res.count);

                // update side cart HTML if returned
                if(res.side_cart_html){
                    var side = document.getElementById('side-cart-content');
                    if(side) side.innerHTML = res.side_cart_html;
                    // initialize tooltips inside side cart if present
                    initTooltips();
                }

                // if server sent guest_token, persist it for subsequent requests
                if(res.guest_token){
                    localStorage.setItem('guest_token', res.guest_token);
                    document.cookie = 'guest_token=' + res.guest_token + '; path=/; max-age=' + (60*60*24*30);
                }

                // small success feedback
                el.innerHTML = '<i class="fa fa-check"></i>';
                setTimeout(()=>{ el.innerHTML = orig; el.disabled = false; }, 700);
            } else {
                el.innerHTML = orig;
                el.disabled = false;
                alert(res.message || 'Failed to add to cart');
            }
        })
        .catch(err => {
            el.innerHTML = orig;
            el.disabled = false;
            alert('Failed to add to cart');
        });
    }
    </script>

    <script>
    function initTooltips(){
        try{
            if(window.bootstrap && typeof window.bootstrap.Tooltip === 'function'){
                // dispose any existing tooltips to avoid duplicates
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el){
                    if(el._tooltip){ try{ el._tooltip.dispose(); }catch(e){}
                    }
                });

                // initialize
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el){
                    var t = new window.bootstrap.Tooltip(el, {delay:{"show":50,"hide":50}});
                    // store reference for potential disposal
                    el._tooltip = t;
                });
            }
        }catch(e){ console.error('Tooltip init error', e); }
    }

    // initialize on initial page load
    document.addEventListener('DOMContentLoaded', function(){ initTooltips(); });
    </script>

    <script>
    // ensure server-side sees the same guest_token on full page loads
    (function() {
        var hasCookie = document.cookie.split(';').some(function(c){ return c.trim().startsWith('guest_token='); });
        var ls = localStorage.getItem('guest_token');
        if (!hasCookie && ls) {
            document.cookie = 'guest_token=' + ls + '; path=/; max-age=' + (60*60*24*30);
        }
    })();
    </script>

</body>

</html>