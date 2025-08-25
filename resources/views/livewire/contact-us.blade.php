@section('meta')
<meta property="title" content="Contact Us | {{ config('app.name') }}" />
<meta property="og:title" content="Contact Us | {{ config('app.name') }}" />
<meta property="og:description" content="{{ strip_tags(settings('about_description')) }}" />
<meta name="description" content="{{ strip_tags(settings('about_description')) }}" />
<meta property="og:image" content="{{ uploadedFile(settings('about_thumbnail')) }}" />
<meta property="og:image:secure_url" content="{{ uploadedFile(settings('about_thumbnail')) }}" />
<meta property="og:image:alt" content="Contact Us | {{ config('app.name') }}" />
<meta property="og:image:type" content="image/jpeg" />
<meta name="twitter:title" content="Contact Us | {{ config('app.name') }}" />
<meta name="twitter:description" content="{{ strip_tags(settings('about_description')) }}" />
<meta name="twitter:image" content="{{ uploadedFile(settings('about_thumbnail')) }}" />
@endsection
<div>
    <section class="breadcrumb"
        style="background-size: cover; background-repeat: no-repeat; background-image: url({{ asset('frontend/assets/img/bg.jpg') }}); padding:20px"
        data-ll-status="entered">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread d-flex justify-content-center">
                        <ul>
                            <li><a href="{{ url('/') }}">Home </a></li>
                            <li><a>/ Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="officeaddress">
        <div class="container">
            <div class="row">
                @php
                $locations = is_array(json_decode(settings('location_title'))) ? json_decode(settings('location_title'))
                : [];
                $descriptions = @json_decode(settings('location_description'));
                $phones = @json_decode(settings('location_phone'));
                @endphp
                @foreach ($locations as $key => $location)
                <div class="col-md-4">
                    <div class="offaddwrp MIRPUR">
                        <h3>
                            <img src="{{ asset('frontend/assets/img/cbal.png') }}" width="632" height="631"
                                style="width:17px;height:17px;">
                            {{ $location }}
                        </h3>
                        <div class="offadd">
                            <p class="text-center"><i class="bi bi-geo-alt"></i></p>
                            <p>{{ @$descriptions[$key] }}</p>
                            <a href="tel:{{ $phones[$key] }}">{{ $phones[$key] }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="contactarea">
        <div class="container">
            <div class="row">
                <div class="col-md-6 p-5">
                    <h1>{{ settings('contact_title') }}</h1>
                    <p>{{ settings('contact_description') }}</p>

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @elseif(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <form wire:submit.prevent='submit()'>
                        <div class="form-group mb-4">
                            <label for="name">Your Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                wire:model='name'>
                            @error('name')
                            <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="email">Your Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                wire:model='email'>
                            @error('email')
                            <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="pwd">Your message</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" wire:model='message'
                                cols="30" rows="10"></textarea>
                            @error('message')
                            <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success submit">Submit</button>
                    </form>
                </div>
                <div class="col-md-6 p-5">
                    <h4>{{ settings('headoffice_title') }}</h4>
                    <p class="d-flex align-items-center"><i class="bi bi-geo-alt-fill"></i>{{
                        settings('headoffice_address') }}</p>
                    <p class="d-flex align-items-center"><i class="bi bi-envelope-fill"></i> {{
                        settings('headoffice_email') }}</p>
                    <p class="d-flex align-items-center"><i class="bi bi-telephone-fill"></i> {{
                        settings('headoffice_phone') }}</p>
                    
                    
                    
                    
                    <style>
                                /* Hide the element by default (on mobile devices) */
                                    .mobile-map {
                                      display: none;
                                    }
                                    
                                    /* Show the element on larger screens (desktops) */
                                    @media (min-width: 768px) {
                                      .mobile-map {
                                        display: block; /* or use 'flex' or 'inline-block' depending on your layout needs */
                                      }
                                    }
                    </style>
                    
                    
                    
                    
                    <div class="mapwrp mobile-map">
                        {!! settings('contact_map_code') !!}
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </section>
</div>
