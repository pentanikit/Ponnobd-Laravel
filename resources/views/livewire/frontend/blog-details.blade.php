<div>
    @section('meta')
    <meta property="title" content="{{ $post->title }}" />
    <meta name="keywords" content="{{ $post->meta_keywords }}" />
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:description" content="{{ strip_tags($post->meta_description) }}" />
    <meta name="description" content="{{ strip_tags($post->meta_description) }}" />
    <meta property="og:image" content="{{ uploadedFile($post->thumbnail) }}" />
    <meta property="og:image:secure_url" content="{{ uploadedFile($post->thumbnail) }}" />
    <meta property="og:image:alt" content="{{ $post->title }}" />
    <meta name="twitter:title" content="{{ $post->title }}" />
    <meta name="twitter:description" content="{{ strip_tags($post->meta_description) }}" />
    <meta name="twitter:image" content="{{ uploadedFile($post->thumbnail) }}" />
    @endsection
    <!-- breadcrumb section -->
    <section class="breadcrumb" style="background-size: cover; background-repeat: no-repeat; background-image: url({{ asset('frontend/assets/img/bg.jpg') }});padding:40px"  data-ll-status="entered">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread d-flex justify-content-center">
                        <ul>
                            <li><a href="{{ url('/') }}">Home </a></li>
                            <li><a>/ Blog Details</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb section -->

    <section class="blogmain">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                             <style>
                .wrap{
    width: 1200px;
    margin: 0 auto;
}

p{
    margin-bottom: 10px; 
    font-size: 16px; 
    color: #01132d;  
    font-family: "Trebuchet MS", sans-serif;
}

h1{
    font-size: 26px; 
    line-height: 35px; 
    margin-bottom: 5px; 
    font-family: "Trebuchet MS", sans-serif;
}

h2{
    font-size: 24px; 
    line-height: 30px; 
    margin-bottom: 5px; 
    font-family: "Trebuchet MS", sans-serif;
}

h3 {
    font-size: 22px; 
    line-height: 26px; 
    margin-bottom: 5px; 
    font-family: "Trebuchet MS", sans-serif;
}

h3 {
    font-size: 20px; 
    line-height: 26px; 
    margin-bottom: 5px; 
    font-family: "Trebuchet MS", sans-serif;
}

.wrap > img{
    width:1200px;
    height: 630px;
}
table{
    width: 100%;
    text-align: center;
    border: 1px solid black;
}

table td{    
    border: 1px solid black;
}

table th{
    border: 1px solid black;
}

li{
    margin-bottom: 0px; 
    font-size: 16px; 
    color: #01132d; line-height: 26px; 
    font-family: "Trebuchet MS", sans-serif;
    margin-left: 15px;
}
</style>
                            <div class="postloop">
                                <div class="loopimg">
                                    <img src="{{ uploadedFile($post->thumbnail) }}" class="img-thumbnail" alt="{{ $post->thumbnail_alt }}">
                                </div>
                                <div class="loop-content">
                                    <a href="" class="tagcat">{{ $post->category?->name }}</a>
                                    <h2 class="looptitile">{{ $post->title }}</h2>
                                    <span class="dateandtime"><i class="bi bi-clock-fill"></i> {{ $post->created_at->format('d M, Y') }}</span>
                                    <p>
                                        {!! $post->description !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sidebarblog">
                                <div class="sidebar shadow searchfrom p-3 pb-5 pt-5 p-3">
                                    <h4 class="text-start sidebartitle">Search</h4>

                                    <form action="{{ route('blog') }}">
                                        <input type="text" name="search" class="form-control" placeholder="Search.." value="{{ request('search') }}"/>
                                        <button class="btn btn-success mt-2" type="submit">Search</button>
                                    </form>
                                </div>
                                <div class="sidebar shadow recentpost p-3 pb-5 pt-5 p-3">
                                    <h4 class="text-start sidebartitle">Related posts</h4>
                                    @foreach ($related as $item)
                                    <div class="row mb-4">
                                        <div class="col-3">
                                            <a href="{{ route('blog.details',$item->slug) }}">
                                                <img src="{{ uploadedFile($item->thumbnail) }}" alt="{{ $item->title }}">
                                            </a>
                                        </div>
                                        <div class="col-9">
                                            <span class="rtp"><a href="{{ route('blog.details',$item->slug) }}">{{ Str::words($item->title,5) }}</a></span>
                                            <span class="rtc">{{ Str::words(strip_tags($item->description),10) }}</span>
                                            <span class="dateandtime"><i class="bi bi-clock-fill"></i> {{ $item->created_at->format('d M, Y') }}</span>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>

                                <div class="sidebar shadow tag p-3 p-3 pb-5 pt-5">
                                    <h4 class="text-start sidebartitle">Keywords</h4>
                                    @foreach (explode(',',$post->meta_keywords) as $keyword)
                                    <a href="#" class="tagcat">{{ $keyword }}</a>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
