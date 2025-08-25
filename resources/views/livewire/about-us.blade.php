
@section('meta')
<meta property="title" content="About Us | {{ config('app.name') }}" />
<meta property="og:title" content="About Us | {{ config('app.name') }}" />
<meta property="og:description" content="{{ strip_tags(settings('about_description')) }}" />
<meta name="description" content="{{ strip_tags(settings('about_description')) }}" />
<meta property="og:image" content="{{ uploadedFile(settings('about_thumbnail')) }}" />
<meta property="og:image:secure_url" content="{{ uploadedFile(settings('about_thumbnail')) }}" />
<meta name="twitter:title" content="About Us | {{ config('app.name') }}" />
<meta name="twitter:description" content="{{ strip_tags(settings('about_description')) }}" />
<meta name="twitter:image" content="{{ uploadedFile(settings('about_thumbnail')) }}" />
@endsection

<style> 
.about {
    display:none !important;
}

</style>
<div style="margin-top:20px">
    <!--<section class="breadcrumb" style="background-size: cover; background-repeat: no-repeat; background-image: url({{ asset('frontend/assets/img/bg.jpg') }}); padding:40px" data-ll-status="entered">-->
    <!--    <div class="container">-->
    <!--        <div class="row">-->
    <!--            <div class="col-12">-->
    <!--                <div class="bread d-flex justify-content-center">-->
                       
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->
    @php
        $services = is_array(json_decode(settings('service_title'))) ? json_decode(settings('service_title')) : [];
        $descriptions = @json_decode(settings('service_description'));
        $icons = @json_decode(settings('service_icon'));
        $certificates = explode(',',settings('certificates'));
    @endphp
    <section class="aboutpage">
        <div class="container">
            {{-- <div class="row justify-content-between">
                <div class="col-md-5 suto">
                    <div class="contentpageimg">
                        <img width="1084" height="1094" src="{{ uploadedFile( settings('about_thumbnail')) }}">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="contentpage">
                        <div class="ceospace">
                            
                            
                            <h2 style="text-align:center !important" class="fw-bold text-center">{{ settings('ceo_speech_title') }}</h2>
                            <p>
                                {!! settings('ceo_description') !!}
                            </p>
                            
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-5 boro">
                    <div class="contentpageimg">
                        <img width="1084" height="1094" src="{{ uploadedFile(settings('about_thumbnail')) }}" loading="lazy">
                    </div>
                </div>
            </div> --}}
           <div class="contentpage"> <span class="about">About us</span>
                <div class="ceospace">
                    <h2 class="fw-bold" style="text-align:center">{{ settings('ceo_speech_title') }}</h2>
                    <p>
                        {!! settings('ceo_description') !!}
                    </p>
                </div>
            </div>
           
            <h2 class="pagetitle" ><b>{{ settings('about_title') }}</b></h2>
            
            <p>{!! settings('about_description') !!} </p><br>
            <div class="towitem">
                @foreach ($services as $key => $title)
                <div class="row justify-content-center align-items-center">
                    {{-- <div class="col-2">
                        <img width="100" height="100" src="{{ uploadedFile(@$icons[$key]) }}" alt="" loading="lazy">
                    </div> --}}
                    <div class="col-12">
                        <h5 class="fw-bold" style="color:hsl(var(--base));">{{ $title }}</h5>
                        <p>{!! @$descriptions[$key] !!}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- <div class="row mt-5">
                @foreach ($certificates as $certificate)
                <div class="col-md-4 col-6">
                    <div class="aimgbox">
                        <img width="620" height="877" src="{{ uploadedFile($certificate) }}" loading="lazy">
                    </div>
                </div>
                @endforeach
            </div> --}}
        </div>
    </section>
</div>
