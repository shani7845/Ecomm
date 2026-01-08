{{-- NAVBAR --}}
<div class="header-dashboard">
    <div class="wrap">

        {{-- LEFT --}}
        <div class="header-left">
            <a href="{{ route('admin.dashboard') }}">
                <img id="logo_header_mobile" src="{{ asset('admin/images/logo/logo.png') }}"
                    data-light="{{ asset('admin/images/logo/logo.png') }}"
                    data-dark="{{ asset('admin/images/logo/logo-dark.png') }}" alt="Logo" />
            </a>

            <div class="button-show-hide">
                <i class="icon-menu-left"></i>
            </div>

            {{-- SEARCH --}}
            <form class="form-search flex-grow">
                <fieldset class="name">
                    <input type="text" placeholder="Search here..." class="show-search" />
                </fieldset>
                <div class="button-submit">
                    <button type="submit">
                        <i class="icon-search"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- RIGHT --}}
        <div class="header-grid">

            {{-- LANGUAGE --}}
            <div class="header-item country">
                <select class="image-select no-text">
                    <option data-thumbnail="{{ asset('admin/images/country/1.png') }}">ENG</option>
                    <option data-thumbnail="{{ asset('admin/images/country/9.png') }}">VIE</option>
                </select>
            </div>

            {{-- DARK MODE --}}
            <div class="header-item button-dark-light">
                <i class="icon-moon"></i>
            </div>

            {{-- NOTIFICATION --}}
            <div class="popup-wrap noti type-header">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="header-item">
                            <span class="text-tiny">1</span>
                            <i class="icon-bell"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <h6>Notifications</h6>
                        </li>
                        <li><a href="#" class="dropdown-item">New Order</a></li>
                        <li><a href="#" class="dropdown-item">New Message</a></li>
                    </ul>
                </div>
            </div>

            {{-- USER --}}
            <div class="popup-wrap user type-header">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="header-user wg-user">
                            <span class="image">
                                <img src="{{ asset('admin/images/avatar/user-1.png') }}" alt="">
                            </span>
                            <span class="flex flex-column">
                                <span class="body-title mb-2">
                                    {{ auth()->user()->name ?? 'Admin' }}
                                </span>
                                <span class="text-tiny">Admin</span>
                            </span>
                        </span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="#" class="user-item">
                                <i class="icon-user"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" class="user-item"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="icon-log-out"></i> Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>