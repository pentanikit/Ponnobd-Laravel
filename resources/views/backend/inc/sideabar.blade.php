<aside class="sidenav navbar navbar-vertical navbar-expand-xs fixed-start bg-default">
    <div class="sidenav-header">
        <i class="fas fa-times text-secondary position-absolute d-none d-xl-none end-0 top-0 cursor-pointer p-3 opacity-5"
            aria-hidden="true" id="iconSidenav">
        </i>
        <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
            {{-- <img src="backend/assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo"> --}}
            <h3 class="font-weight-bold ms-1 text-white">
                @if(config('app.url') == 'https://pentanik.com')
                PENTANIK
                @else
                PONNO BD
                @endif
            </h3>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="navbar-collapse collapse h-auto w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <h6 class="text-uppercase ms-2 ps-4 text-xs">System</h6>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" @class(['nav-link ', 'active' => Route::is('dashboard')])>
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-shop text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#products" class="nav-link" aria-controls="products" role="button"
                    aria-expanded="false">
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-archive-2 text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Catalog</span>
                </a>
                <div @class(['collapse','show' => Route::is('categories.index') || Route::is('brand.index') || Route::is('products.index') || Route::is('attribute.index') || Route::is('attribute.show')]) id="products">
                    <ul class="nav ms-4">
                        @can('categories_view')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('categories.index') }}">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal"> Categories </span>
                            </a>
                        </li>
                        @endcan
                        @can('brands_view')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('brand.index') }}">
                                <span class="sidenav-mini-icon"> B </span>
                                <span class="sidenav-normal"> Brands </span>
                            </a>
                        </li>
                        @endcan
                        @can('products_view')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal"> Products </span>
                            </a>
                        </li>
                        @endcan
                        @can('attributes_view')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('attribute.index') }}">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal"> Attributes </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>

            @can('orders_view')
            @php
                $pending_orders = App\Models\Order::where('status', 'pending')->count();
            @endphp
            <li class="nav-item">
                <a href="{{ route('order.index') }}" @class(['nav-link ', 'active' => Route::is('order.index')])>
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-cart text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Orders </span>
                    @if ($pending_orders > 0)
                        <span class="badge bg-danger ml-auto text-white">{{ $pending_orders }}</span>
                    @endif
                </a>
            </li>
            @endcan


            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#posts" class="nav-link" aria-controls="posts" role="button"
                    aria-expanded="false">
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-bold text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Blog</span>
                </a>
                <div @class(["collapse",'show' => Route::is('blog.categories.index') || Route::is('posts.index')]) id="posts">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog.categories.index') }}">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal"> Categories </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.index') }}">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal"> Posts </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @can('customers_view')
            <li class="nav-item">
                <a href="{{ route('customers.index') }}" @class(['nav-link ', 'active' => Route::is('customers.index')])>
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-user-run text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Customers </span>
                </a>
            </li>
            @endcan
            @role('admin')
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#roles" class="nav-link" aria-controls="roles" role="button"
                    aria-expanded="false">
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-lock-circle-open text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">System Access </span>
                </a>
                <div @class(["collapse",'show' => Route::is('staff.index') || Route::is('roles.index')]) id="roles">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('staff.index') }}">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal"> Staffs </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('roles.index') }}">
                                <span class="sidenav-mini-icon"> R&P </span>
                                <span class="sidenav-normal"> Roles & Permissions </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endrole

            {{-- Website Section --}}
            <li class="nav-item mt-3">
                <h6 class="text-uppercase ms-2 ps-4 text-xs">Website Settings</h6>
            </li>

            @if(auth()->user()->can('page_view')
                && auth()->user()->can('home_page')
                && auth()->user()->can('about_us_page')
                && auth()->user()->can('contact_us_page')
            )
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#pages" class="nav-link" aria-controls="pages" role="button"
                    aria-expanded="false">
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-book-bookmark text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pages</span>
                </a>
                <div @class(['collapse','show' => Route::is('pages.index') || Route::is('pages.home') || Route::is('pages.about.us') || Route::is('pages.contact.us')]) id="pages">
                    <ul class="nav ms-4">
                        @can('page_view')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages.index') }}">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal"> Additional Pages </span>
                            </a>
                        </li>
                        @endcan
                        @can('home_page')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages.home') }}">
                                <span class="sidenav-mini-icon"> H </span>
                                <span class="sidenav-normal"> Home </span>
                            </a>
                        </li>
                        @endcan
                        @can('about_us_page')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages.about.us') }}">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal"> About Us </span>
                            </a>
                        </li>
                        @endcan
                        @can('contact_us_page')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages.contact.us') }}">
                                <span class="sidenav-mini-icon"> CS </span>
                                <span class="sidenav-normal"> Contact Us </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endif
            @can('category_menus')
            <li class="nav-item">
                <a href="{{ route('categories.menus.index') }}" @class(['nav-link ', 'active' => Route::is('categories.menus.index')])>
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-atom text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Categories Menus</span>
                </a>
            </li>
            @endcan
            @can('system_settings')
            <li class="nav-item">
                <a href="{{ route('settings.system') }}" @class(['nav-link ', 'active' => Route::is('settings.system')])>
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-app text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">System Settings</span>
                </a>
            </li>
            @endcan
            @can('header_settings')
            <li class="nav-item">
                <a href="{{ route('settings.header') }}" @class(['nav-link ', 'active' => Route::is('settings.header')])>
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-scissors text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Header Settings</span>
                </a>
            </li>
            @endcan
            @can('display_section_settings')
            <li class="nav-item">
                <a href="{{ route('settings.home.section.index') }}" @class([
                    'nav-link ',
                    'active' => Route::is('settings.home.section.index'),
                ])>
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-laptop text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Display Section </span>
                </a>
            </li>
            @endcan
            @can('footer_settings')
            <li class="nav-item">
                <a href="{{ route('settings.footer') }}" @class(['nav-link ', 'active' => Route::is('settings.footer')])>
                    <div class="icon icon-shape icon-sm d-flex align-items-center justify-content-center text-center">
                        <i class="ni ni-tie-bow text-secondary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Footer Settings</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</aside>
