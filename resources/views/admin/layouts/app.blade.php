<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- ================= CSS ================= --}}
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/icon/style.css') }}">

</head>

<body class="body">

    <div id="wrapper">
        <div id="page">
            <div class="layout-wrap">

                {{-- ========== SIDEBAR ========== --}}
                @include('admin.layouts.sidebar')

                {{-- ========== RIGHT CONTENT ========== --}}
                <div class="section-content-right">

                    {{-- NAVBAR --}}
                    @include('admin.layouts.navbar')

                    {{-- MAIN CONTENT --}}
                    <div class="main-content">
                        @yield('content')
                    </div>

                    {{-- FOOTER --}}
                    @include('admin.layouts.footer')

                </div>
            </div>
        </div>
    </div>

    {{-- ================= JS ================= --}}
    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('admin/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/carousel.js') }}"></script>
    <script src="{{ asset('admin/js/main.js') }}"></script>

    <script src="{{ asset('admin/js/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('admin/js/apexcharts/line-chart-1.js') }}"></script>
    <script src="{{ asset('admin/js/apexcharts/line-chart-2.js') }}"></script>
    <script src="{{ asset('admin/js/apexcharts/line-chart-3.js') }}"></script>
    <script src="{{ asset('admin/js/apexcharts/line-chart-4.js') }}"></script>
    <script src="{{ asset('admin/js/apexcharts/line-chart-5.js') }}"></script>
    <script src="{{ asset('admin/js/apexcharts/line-chart-6.js') }}"></script>

</body>

</html>