<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  {{-- 0 Boot dataLayer BEFORE GTM --}}
  <script>
    window.dataLayer = window.dataLayer || [];
    @auth dataLayer.push({ user_id: "{{ auth()->id() }}" }); @endauth

    // Local dev logger (remove in prod)
    (function () {
      if (location.hostname === '127.0.0.1' || location.hostname === 'localhost') {
        const _push = dataLayer.push;
        dataLayer.push = function () { console.log('[dataLayer.push]', ...arguments); return _push.apply(this, arguments); };
      }
    })();
  </script>

  {{-- 1 GTM HEAD right after dataLayer --}}
  @include('partials.gtm-head')

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>{{ $title ?? 'Home' }}</title>
  <meta name="language" content="English">
  <meta name="author" content="{{ config('app.name') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="app-url" content="{{ url('/') }}">
  <meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>

  <link rel="canonical" href="{{ $canonical ?? url()->current() }}" />
  <link rel="icon" href="{{ uploadedFile(settings('site_icon')) }}" sizes="32x32" />
  <link rel="icon" href="{{ uploadedFile(settings('site_icon')) }}" sizes="192x192" />
  <link rel="apple-touch-icon" href="{{ uploadedFile(settings('site_icon')) }}" />

  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url('/') }}" />
  <meta property="og:site_name" content="{{ config('app.name') }}" />

  @yield('meta')

  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('frontend/v2/css/line-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/v2/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/v2/css/fontawesome-all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/v2/css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/v2/css/animate.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/v2/css/splitting.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/v2/css/magiczoom.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/v2/css/main.css?v=3.7') }}">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- 2) Analytics helpers + robust SPA page_view shim --}}
  <script>
    // ---- Ecommerce helpers ----
    window.Analytics = {
      addToCart(item) {
        dataLayer.push({
          event: 'add_to_cart',
          ecommerce: {
            currency: 'BDT',
            value: (item.price || 0) * (item.quantity || 1),
            items: [{
              item_id: item.id, item_name: item.name, item_brand: item.brand,
              item_category: item.category, price: item.price, quantity: item.quantity || 1
            }]
          }
        });
      },
      beginCheckout(cart) {
        dataLayer.push({
          event: 'begin_checkout',
          ecommerce: {
            currency: 'BDT',
            value: cart.total || 0,
            items: (cart.items || []).map(p => ({
              item_id: p.id, item_name: p.name, item_brand: p.brand,
              item_category: p.category, price: p.price, quantity: p.qty
            }))
          }
        });
      },
      purchase(order) {
        dataLayer.push({
          event: 'purchase',
          ecommerce: {
            currency: 'BDT',
            transaction_id: order.invoice_no,
            value: order.total,
            shipping: order.shipping || 0,
            tax: order.tax || 0,
            items: (order.items || []).map(it => ({
              item_id: it.id, item_name: it.name, item_brand: it.brand,
              item_category: it.category, price: it.price, quantity: it.qty
            }))
          }
        });
      }
    };

    // ---- Extra custom events ----
    window.addEventListener('view-item', (e) => {
      const p = e.detail || {};
      dataLayer.push({
        event: 'view_item',
        ecommerce: {
          currency: 'BDT',
          value: p.price || 0,
          items: [{
            item_id: p.id, item_name: p.name, item_brand: p.brand,
            item_category: p.category, price: p.price, quantity: p.quantity || 1
          }]
        }
      });
    });

    window.addEventListener('add-to-wishlist', (e) => {
      const p = e.detail || {};
      dataLayer.push({
        event: 'add_to_wishlist',
        ecommerce: {
          currency: 'BDT',
          value: p.price || 0,
          items: [{
            item_id: p.id, item_name: p.name, item_brand: p.brand,
            item_category: p.category, price: p.price, quantity: 1
          }]
        }
      });
    });

    window.addEventListener('review-submitted', (e) => {
      const d = e.detail || {};
      dataLayer.push({ event: 'review_submitted', product_id: d.product_id, rating: d.rating });
    });

    // ---- Bridge browser events → helpers ----
    window.addEventListener('add-to-cart',    e => window.Analytics.addToCart(e.detail));
    window.addEventListener('begin-checkout', e => window.Analytics.beginCheckout(e.detail));
    window.addEventListener('purchase',       e => window.Analytics.purchase(e.detail));

    // ---- Robust SPA page_view shim ----
    (function () {
      let lastHref = location.href;

      function pushPageView(reason) {
        const href = location.href;
        if (href === lastHref) return;
        lastHref = href;
        dataLayer.push({ event: 'page_view', page_location: href, page_title: document.title, _source: reason });
      }

      // 1) Livewire v3 navigation (if used)
      document.addEventListener('livewire:navigated', () => pushPageView('livewire'));

      // 2) History API (most SPAs)
      const _ps = history.pushState, _rs = history.replaceState;
      history.pushState = function () { const r = _ps.apply(this, arguments); window.dispatchEvent(new Event('locationchange')); return r; };
      history.replaceState = function () { const r = _rs.apply(this, arguments); window.dispatchEvent(new Event('locationchange')); return r; };
      window.addEventListener('popstate', () => window.dispatchEvent(new Event('locationchange')));
      window.addEventListener('locationchange', () => pushPageView('history'));

      // 3) Fallback: if DOM changes but URL doesn’t change (rare Livewire morphs)
      const titleObserver = new MutationObserver(() => { pushPageView('title-change'); });
      titleObserver.observe(document.querySelector('title') || document.documentElement, { childList: true, subtree: true });
    })();
  </script>

  {{-- Facebook Pixel (optional) --}}
  <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}
    (window, document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2710548559245038'); fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=2710548559245038&ev=PageView&noscript=1"/></noscript>
</head>

<body x-data="{ cartSummaryOpened:false, checkoutModal:false }">
  {{-- 3) GTM BODY must be FIRST in body --}}
  @include('partials.gtm-body')

  {{-- Header --}}
  @livewire('frontend.inc.header')

  {{-- Main --}}
  <div class="main-content">
    {{ $slot }}
  </div>

  {{-- Cart Summary --}}
  @livewire('frontend.cart-summary')

  {{-- Footer --}}
  <footer class="footer-area overflow--hidden">
    <div class="thumb--wrap bg--img">
      <img src="{{ uploadedFile(settings('footer_logo')) }}">
    </div>

    <div class="footer-top">
      <div class="container-fluid">
        <div class="row gy-4 justify-content-center py-3">
          @php
            $widget_one = is_array(json_decode(settings('widget_one_title'))) ? json_decode(settings('widget_one_title')) : [];
            $widget_one_links = @json_decode(settings('widget_one_link'));
          @endphp
          <div class="col-xl-2 col-sm-6">
            <div class="footer-item">
              <h5 class="footer-item--title">{{ settings('widget_title_one') }}</h5>
              <ul class="footer--menu">
                @foreach ($widget_one as $key => $one)
                  <li class="menu--item"><a href="{{ @$widget_one_links[$key] }}" class="menu--link">{{ $one }}</a></li>
                @endforeach
              </ul>
            </div>
          </div>

          @php
            $widget_two = is_array(json_decode(settings('widget_two_title'))) ? json_decode(settings('widget_two_title')) : [];
            $widget_two_links = @json_decode(settings('widget_two_link'));
          @endphp
          <div class="col-xl-2 col-sm-6">
            <div class="footer-item">
              <h5 class="footer-item--title">{{ settings('widget_title_two') }}</h5>
              <ul class="footer--menu">
                @foreach ($widget_two as $key => $two)
                  <li class="menu--item"><a href="{{ @$widget_two_links[$key] }}" class="menu--link">{{ $two }}</a></li>
                @endforeach
              </ul>
            </div>
          </div>

          @php
            $footer_showrooms = is_array(json_decode(settings('footer_showroom_title'))) ? json_decode(settings('footer_showroom_title')) : [];
            $footer_descriptions = @json_decode(settings('footer_showroom_description'));
            $footer_one_phones = @json_decode(settings('footer_showroom_phone_one'));
            $footer_two_phones = @json_decode(settings('footer_showroom_phone_two'));
          @endphp

          @foreach ($footer_showrooms as $key => $title)
          <div class="col-xl-2 col-sm-6">
            <div class="footer-item">
              <h5 class="footer-item--title text-start text-sm-end">{{ $title }}</h5>
              <div class="footer-contact-info mb-3 d-flex justify-content-end flex-column gap-1">
                <div class="d-flex justify-content-end align-items-center">
                  <p class="fw--400 text-start text-sm-end">{{ @$footer_descriptions[$key] }}</p>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                  <p class="text-start text-sm-end"><a href="tel:{{ @$footer_one_phones[$key] }}">{{ @$footer_one_phones[$key] }}</a></p>
                </div>
              </div>

              @if($loop->last)
              <div class="footer-contact-info mb-3 d-flex justify-content-end flex-column gap-1">
                <div class="d-flex justify-content-end align-items-center">
                  <p class="text--black fs--18 fw--600 text-start text-sm-end">Follow {{ config('app.name') }}</p>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                  <p class="text-start text-sm-end">Please give a feedback</p>
                </div>
              </div>

              <ul class="social-list flex-wrap justify-content-start justify-content-sm-end">
                <li class="social-list--item"><a href="{{ settings('fb_link') }}" class="social-list__link icon-wrapper"><div class="icon"><i class="fab fa-facebook-f"></i></div></a></li>
                <li class="social-list--item"><a href="{{ settings('yt_link') }}" class="social-list__link icon-wrapper active"><div class="icon"><i class="fa-brands fa-youtube"></i></div></a></li>
                <li class="social-list--item"><a href="{{ settings('linkedin_link') }}" class="social-list__link icon-wrapper"><div class="icon"><i class="fab fa-linkedin-in"></i></div></a></li>
                <li class="social-list--item"><a href="{{ settings('insta_link') }}" class="social-list__link icon-wrapper"><div class="icon"><i class="fab fa-instagram"></i></div></a></li>
              </ul>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="bottom-footer pt-4 pb-3">
        <div class="container">
          <div class="row text-center gy-2">
            <div class="col-lg-12">
              <div class="bottom-footer-text">{!! settings('copyright_text') !!}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  {{-- Floating WhatsApp --}}
  <style>
    .whatsapp-container{position:fixed;right:30px;bottom:15px;z-index:999}
    .whatsapp-button{background-color:rgb(37,50,136);color:#fff;display:flex;align-items:center;padding:7px 30px;border-radius:50px;text-decoration:none;font-family:sans-serif;font-size:16px;font-weight:bold;box-shadow:0 4px 8px rgba(0,0,0,.2);transition:all .3s ease}
    .whatsapp-button:hover{background-color:gray}.whatsapp-button i{font-size:28px;margin-right:10px}
  </style>
  <div class="whatsapp-container">
    <a href="https://wa.link/8riuag" class="whatsapp-button" target="_blank" rel="noopener">
      <i class="lab la-whatsapp"></i><span>Connect with Us</span>
    </a>
  </div>

  {{-- JS --}}
  <script src="{{ asset('frontend/v2/js/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('frontend/v2/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/v2/js/slick.min.js') }}"></script>
  <script src="{{ asset('frontend/v2/js/wow.min.js') }}"></script>
  <script src="{{ asset('frontend/v2/js/splitting.min.js') }}"></script>
  <script src="{{ asset('frontend/v2/js/magiczoom.js') }}"></script>
  <script src="{{ asset('frontend/v2/js/main.js?v=1.4') }}"></script>
</body>
</html>
