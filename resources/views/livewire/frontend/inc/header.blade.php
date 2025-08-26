<div>
    <div class="sidebar-overlay" :class="cartSummaryOpened ? 'show' : ''"></div>
    <!-- Header Start -->
    
    <div class="header-main-area">
        <div class="header" id="header">
            <div class="container-fluid position-relative">
                <div class="header-wrapper">
                    <!-- ham menu -->
                    <i class="fa-sharp fa-solid fa-bars-staggered ham__menu" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"></i>

                    <!-- logo -->
                    <div class="header-menu-wrapper align-items-center d-flex">
                        <div class="logo-wrapper">
                            <a href="{{ url('/') }}" class="normal-logo" id="normal-logo"> 
                                <img src="{{ uploadedFile(settings('header_logo')) }}" alt="...">
                            </a>
                        </div>

                        <div class="menu-list-wrapper d-flex align-items-center position-relative">
                            <button class="search-toggle--btn">
                                <i class="fa-solid fa-magnifying-glass text--black"></i>
                            </button>

                            <ul class="main-menu">
                                <li class="position-relative">
                                    <a class="active menu-item" href="#" id="menu-item-1">
                                        <i class="fa-solid fa-bars me-2"></i> Product
                                    </a>
                                    
                                    <ul class="sub-menu" id="sub-menu-1">
                                        <li class="sub-menu-item" id="sub-item-1">
                                            <a href="{{ config('app.url') }}/led-tv-price-in-bangladesh">Television</a>
                                        </li>
                                        
                                        <li class="sub-menu-item" id="sub-item-2">
                                            <a href="{{ config('app.url') }}/pentanik-ac-price-in-bangladesh">Air Condition</a>
                                        </li>
                                        
                                        <li class="sub-menu-item">
                                            <a href="{{ config('app.url') }}/pentanik-fan-price-in-bangladesh">Pentanik Fan</a>
                                        </li>
                                        
                                        <li class="sub-menu-item">
                                            <a href="{{ config('app.url') }}/home-appliances">Home Appliances</a>
                                        </li>
                                        
                                        <li class="sub-menu-item">
                                            <a href="#">Others</a>
                                        </li>
                                        
                                        <div class="inner-menu" id="inner-menu-1-1">
                                            <ul class="inner-items-wrap">
                                                <li class="inner-item">
                                                    <a href="{{ config('app.url') }}/regular-pentanik-tv">Regular Model</a>
                                                </li>
                                                <li class="inner-item">
                                                    <a href="{{ config('app.url') }}/pentanik-special-edition">Special Model</a>
                                                </li>
                                                <li class="inner-item">
                                                    <a href="{{ config('app.url') }}/pentanik-premium-tv">Premium Model</a>
                                                </li>
                                            </ul>
                                        </div>
                                        
                                        <div class="inner-menu" id="inner-menu-1-2">
                                            <ul class="inner-items-wrap">
                                                <li class="inner-item">
                                                    <a href="{{ config('app.url') }}/pentanik-ac-price-in-bangladesh">Non-Inverter</a>
                                                </li>
                                                <li class="inner-item">
                                                    <a href="{{ config('app.url') }}/pentanik-ac-price-in-bangladesh">Inverter</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </ul>
                                </li>
                                
                                <li class="position-relative">
                                    <a class="active menu-item" href="{{ config('app.url') }}/led-tv-price-in-bangladesh" id="menu-item-2">
                                        <i class="fa-solid fa-tv me-2"></i> TV
                                    </a>
                                    
                                    <ul class="sub-menu" id="sub-menu-2">
                                        <li class="sub-menu-item">
                                            <a href="{{ config('app.url') }}/led-tv-price-in-bangladesh">Pentanik TV</a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ config('app.url') }}/discover-tv-price-in-bangladesh">Discover TV</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/jpe-tv-price-in-bangladesh">JPE TV</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/tcl-tv-price-in-bangladesh">TCL TV</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/sony-tv-price-in-bangladesh">Sony Tv</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/samsung-tv-price-in-bangladesh">Samsung TV</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/walton-tv">Walton TV</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/xiaomi-tv">Xiaomi TV</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/vision-tv-price-in-bangladesh">Vision TV</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/rowa-tv">Rowa TV</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/lg-tv-price-in-bangladesh">LG TV</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="position-relative">
                                    <a class="active menu-item" href="{{ config('app.url') }}/pentanik-ac-price-in-bangladesh" id="menu-item-3">
                                        <i class="fa-solid fa-credit-card me-2"></i>AC
                                    </a>
                                    
                                    <ul class="sub-menu" id="sub-menu-3">
                                        <li class="sub-menu-item" id="sub-item-1-2">
                                            <a href="{{ config('app.url') }}/pentanik-ac-price-in-bangladesh">Pentanik AC</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-1-2">
                                            <a href="{{ config('app.url') }}/jpe-ac-price-in-bangladesh">JPE AC</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-2-2">
                                            <a href="{{ config('app.url') }}/chigo-ac-price-in-bangladesh">Chigo AC</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/general-ac-price-in-bangladesh">General AC</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/gree-ac-price-in-bangladesh">Gree AC</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/hitachi-ac-price-in-bangladesh">Hitachi AC</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/midea-ac-price-in-bangladesh">Media AC</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/portable-ac">Portable AC</a>
                                        </li>
                                        <li class="sub-menu-item" id="sub-item-3-2">
                                            <a href="{{ config('app.url') }}/ac-price-in-bangladesh">All types AC</a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="{{ config('app.url') }}/starlink-price-in-bangladesh">Starlink</a>
                                </li>
                                <li>
                                    <a href="{{ config('app.url') }}/pentanik-smartboard-price-in-bangladesh">Smartboard</a>
                                </li>

                                <li>
                                    <a href="{{ config('app.url') }}/about-us">About</a>
                                </li>

                            </ul>

                            <form action="{{ route('shop') }}" class="search--form">
                                <input class="header--input" name="query" placeholder="Search..." autocomplete="off" value="{{ request('query') }}">
                                <button class="search--btn">
                                    <i class="fa-solid fa-magnifying-glass text--black"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <ul class="login-lng d-flex align-items-center gap--24">
                        <li>
                            <a href="{{ config('app.url') }}/contact-us" class="fw--600 fs--16">Contact</a>
                        </li>
                        <li>
                            <a class="login--btn" href="{{ config('app.url') }}/login">
                                <i class="fa-solid fa-users fs--18"></i>
                            </a>
                        </li>
                        <li class="position-relative">
                            <button class="cart--btn" @click="cartSummaryOpened = true">
                                <i class="fa-solid fa-cart-shopping fs--18 text--white"></i>
                            </button>
                            <span class="count--item position-absolute">{{ $cartCount }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar mobile menu wrap Start-->
    <div class="offcanvas offcanvas-start text-bg-light" tabindex="-1" id="offcanvasExample">
        <div class="offcanvas-header">
            <div class="logo">
                <div class="align-items-center d-flex">
                    <div class="logo-wrapper">
                        <a href="{{ url('/') }}" class="normal-logo" id="offcanvas-logo-normal">
                            <img src="{{ uploadedFile(settings('header_logo')) }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @auth
            <div class="user-info">
                <div class="user-thumb">
                    <a href="{{ url('/') }}">
                        <img src="{{ profilePic() }}" alt="Pic">
                    </a>
                </div>
                <a href="{{ route('customer.dashboard') }}">
                    <h4>{{ auth()->user()->name }}</h4>
                </a>
            </div>
            @endauth

            <ul class="sidebar-menu-list">
                <li class="sidebar-menu-list__item">
                    <a href="{{ url('/') }}" class="sidebar-menu-list__link active">
                        <span class="icon"><i class="fa-solid fa-border-all"></i></span>
                        <span class="text">Home</span>
                    </a>
                </li>

                <li class="sidebar-menu-list__item has-dropdown">
                    <a href="" target="" class="sidebar-menu-list__link">Pentanik TV</a>
                    
                    <div class="sidebar-submenu">
                        <ul class="sidebar-submenu-list">
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/regular-pentanik-tv" class="sidebar-submenu-list__link">
                                    Pentanik Regular
                                </a>
                            </li>
                            
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/pentanik-premium-tv" class="sidebar-submenu-list__link">
                                    Pentanik Premium
                                </a>
                            </li>
                            
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/pentanik-special-edition" class="sidebar-submenu-list__link">
                                    Pentanik Special
                                </a>
                            </li>
                            
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/led-tv-price-in-bangladesh" class="sidebar-submenu-list__link">
                                    All Television
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="sidebar-menu-list__item has-dropdown">
                    <a href="" target="" class="sidebar-menu-list__link">Others TV</a>
                    
                    <div class="sidebar-submenu">
                        <ul class="sidebar-submenu-list">
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/discover-tv-price-in-bangladesh" class="sidebar-submenu-list__link">Discover TV</a>
                            </li>
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/jpe-tv-price-in-bangladesh" class="sidebar-submenu-list__link">JPE TV</a>
                            </li>
                          
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/tcl-tv-price-in-bangladesh" class="sidebar-submenu-list__link">TCL TV</a>
                            </li>
                            
                            <li class="sidebar-menu-list__item has-dropdown">
                                <a href="" target="" class="sidebar-menu-list__link">Others TV</a>
                                
                                <div class="sidebar-submenu">
                                    <ul class="sidebar-submenu-list">
                                        <li class="sidebar-submenu-list__item">
                                            <a href="{{ config('app.url') }}/sony-tv-price-in-bangladesh" class="sidebar-submenu-list__link">Sony Tv</a>
                                        </li>
                                        
                                        <li class="sidebar-submenu-list__item">
                                            <a href="{{ config('app.url') }}/samsung-tv-price-in-bangladesh" class="sidebar-submenu-list__link">Samsung TV</a>
                                        </li>
                                        
                                        <li class="sidebar-submenu-list__item">
                                            <a href="{{ config('app.url') }}/walton-tv" class="sidebar-submenu-list__link">Walton</a>
                                        </li>
                                        
                                        <li class="sidebar-submenu-list__item">
                                            <a href="{{ config('app.url') }}/xiaomi-tv" class="sidebar-submenu-list__link">Xiaomi TV</a>
                                        </li>
                                        
                                        <li class="sidebar-submenu-list__item">
                                            <a href="{{ config('app.url') }}/vision-tv-price-in-bangladesh" class="sidebar-submenu-list__link">Vision TV</a>
                                        </li>
                                        
                                        <li class="sidebar-submenu-list__item">
                                            <a href="{{ config('app.url') }}/rowa-tv" class="sidebar-submenu-list__link">Rowa TV</a>
                                        </li>
                                        
                                        <li class="sidebar-submenu-list__item">
                                            <a href="{{ config('app.url') }}/lg-tv-price-in-bangladesh" class="sidebar-submenu-list__link">LG TV</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="sidebar-menu-list__item has-dropdown">
                    <a href="#" class="sidebar-menu-list__link">Pentanik AC</a>
                    
                    <div class="sidebar-submenu">
                        <ul class="sidebar-submenu-list">
                            <li class="sidebar-submenu-list__item">
                                <a href="" class="sidebar-submenu-list__link">Inverter</a>
                            </li>
                            
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/pentanik-ac-price-in-bangladesh" class="sidebar-submenu-list__link">
                                    Non-Inverter
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="sidebar-menu-list__item has-dropdown">
                    <a href="" target="" class="sidebar-menu-list__link">Others AC</a>
                    
                    <div class="sidebar-submenu">
                        <ul class="sidebar-submenu-list">
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/chigo-ac-price-in-bangladesh" class="sidebar-submenu-list__link">Chigo AC</a>
                            </li>
                            
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/jpe-ac-price-in-bangladesh" class="sidebar-submenu-list__link">JPE AC</a>
                            </li>
                            
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/general-ac-price-in-bangladesh" class="sidebar-submenu-list__link">General AC</a>
                            </li>
                            
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/gree-ac-price-in-bangladesh" class="sidebar-submenu-list__link">Gree AC</a>
                            </li>
                            
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/hitachi-ac-price-in-bangladesh" class="sidebar-submenu-list__link">Hitachi AC</a>
                            </li>
                            
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/midea-ac-price-in-bangladesh" class="sidebar-submenu-list__link">Media AC</a>
                            </li>
                            
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ config('app.url') }}/portable-ac" class="sidebar-submenu-list__link">Portable AC</a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="sidebar-menu-list__item">
                    <a href="{{ config('app.url') }}/home-appliances" target="" class="sidebar-menu-list__link">
                        Home Appliances
                    </a>
                </li>
                
                <li class="sidebar-menu-list__item">
                    <a href="" target="" class="sidebar-menu-list__link">Others</a>
                </li>
                
                <li class="sidebar-menu-list__item">
                    <a href="{{ config('app.url') }}/starlink-price-in-bangladesh" target="" class="sidebar-menu-list__link">
                        Starlink
                    </a>
                    
                    <a href="{{ config('app.url') }}/about-us" target="" class="sidebar-menu-list__link">
                        About us
                    </a>
                </li>
                
                <li class="sidebar-menu-list__item">
                    <a href="{{ config('app.url') }}/blog" target="" class="sidebar-menu-list__link">Blog</a>
                </li>
                
                <li class="sidebar-menu-list__item">
                    <a href="{{ config('app.url') }}/pentanik-smartboard-price-in-bangladesh" target="" class="sidebar-menu-list__link">
                        Smartboard
                    </a>
                </li>
                
                <li class="sidebar-menu-list__item">
                    <a href="{{ config('app.url') }}/contact-us" target="" class="sidebar-menu-list__link">
                        Contact Us
                    </a>
                </li>

                @auth
                <li class="sidebar-menu-list__item has-dropdown">
                    <a href="javascript:void(0)" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fa-solid fa-gears"></i></span>
                        <span class="text">Setting</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul class="sidebar-submenu-list">
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ route('customer.profile') }}" class="sidebar-submenu-list__link">Profile Setting</a>
                            </li>
                            <li class="sidebar-submenu-list__item">
                                <a href="{{ route('customer.profile') }}" class="sidebar-submenu-list__link">Change Password</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</div>