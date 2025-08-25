<div>
     <!--breadcrumb section -->
    <section class="breadcrumb" style="background-size: cover; background-repeat: no-repeat; background-image: url({{ asset('frontend/assets/img/bg.jpg') }});padding:40px" data-ll-status="entered">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread d-flex justify-content-center">
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <style>
        .loop-content {
          
            margin: 0 0px 56px !important;
    
            }
    </style>
     <!--breadcrumb section -->

    <section class="blogmain">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10">
                    <div class="row">
                        <div class="col-md-12">
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
                            @forelse ($posts as $post)
                            <div class="postloop">
                                <div class="loopimg text-center">
                                    <img src="{{ uploadedFile($post->thumbnail) }}" class="img-thumbnail" alt="{{ $post->thumbnail_alt }}">
                                </div>
                                <div class="loop-content">
                                    <span class="tagcat">{{ $post->category?->name }}</span> <br>
                                    <a href="{{ route('blog.details',$post->slug) }}"><h2 class="looptitile">{{ $post->title }}</h2></a><br> 
                                    <span class="dateandtime"><i class="bi bi-clock-fill"></i> {{ $post->created_at->format('d M Y') }}</span><br>
                                    <p>
                                        {{ Str::words(strip_tags($post->description),70) }}
                                    </p>
                                    <a href="{{ route('blog.details',$post->slug) }}" class="readmore">Read More <i class="bi bi-arrow-right-short"></i></a>
                                </div>
                            </div>
                            @empty
                            <div class="text-center">No Post Found!</div>
                            @endforelse

                            <nav aria-label="Page navigation">
                                {{ $posts->links() }}
                            </nav>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>








