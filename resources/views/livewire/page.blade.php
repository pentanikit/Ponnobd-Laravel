@section('meta')
<meta property="title" content="{{ $page->meta_title }} | {{ config('app.name') }}" />
<meta property="og:title" content="{{ $page->meta_title }} | {{ config('app.name') }}" />
<meta property="og:description" content="{{ strip_tags($page->meta_description) }}" />
<meta name="description" content="{{ strip_tags($page->meta_description) }}" />
<meta name="keywords" content="{{ $page->keywords }}" />
<meta property="og:image" content="{{ uploadedFile(settings('header_logo')) }}" />
<meta property="og:image:secure_url" content="{{ uploadedFile(settings('header_logo')) }}" />
<meta name="twitter:title" content="{{ $page->meta_title }} | {{ config('app.name') }}" />
<meta name="twitter:description" content="{{ strip_tags($page->meta_description) }}" />
<meta name="twitter:image" content="{{ uploadedFile(settings('header_logo')) }}" />
@endsection
<div>
    <!-- breadcrumb section -->
        
        <section class="breadcrumb" style="background-size: cover; background-repeat: no-repeat; background-image: url(https://pentanik.com/public/frontend/assets/img/bg.jpg); padding:20px;" data-ll-status="entered">

        
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread d-flex justify-content-center">
                        <ul>
                            <li><a href="{{ route('home') }}">Home </a></li>
                            <li><a>/ {{ $page->name }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb section -->

    <!-- footer top section -->
    <section class="footertop">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contentwrp">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- footer top section -->
</div>
