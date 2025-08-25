<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/app.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin-ext" type="text/css" rel="stylesheet" />    <!-- Meta Data -->
    


</head> 
<body>
    <div class="loginandregister">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 logingb ">
                    <div class="lgocontent">
                        <h1>WelCome To {{ config('app.name') }}</h1>
                        <div class="loginimg">
                            <img src="{{ asset('frontend') }}/assets/img/login.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
