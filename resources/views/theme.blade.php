<!doctype html>
<html lang="fa">
<head>
    <title> @yield('page_title') </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,intial-scale=1">
    <link rel='stylesheet' href='{{asset('bootstrap/css/bootstrap.min.css')}}'>
    <link rel='stylesheet' href='{{asset('bootstrap/css/bootstrap-theme.min.css')}}'>
    <link rel='stylesheet' href='{{asset('css/styles.css')}}'>
    @yield('page_head')
</head>

<body>
    <div id='page_base'>
        
    <!--nav class='navbar navbar-default'>
        <div class='container-fluid'>
            <div class='navbar-header'>
                <a class='navbar-brand' href='{{ $app['url']->to('/') }}'>افزایش ترافیک سایت</a>
            </div>
            <ul class="nav navbar-nav">
                @yield('main_menu')
            </ul>
        </div>
    </nav!-->
            
        
            @yield('page_body')
            
            
    <script src="{{ asset('jquery/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('bootstrap/css/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/script01.js')}}"></script>
    @yield('page_footer')
    
    </div>
    @yield('page_body2',' ')
</body>

</html>