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


            @yield('page_body')


<div class='container' id="home_footer_layout">
    <br>
    <div class="row">
        <div class="col-sm-4">
            <h4>آخرین سایت های ثبت شده</h4>
            <ul>
                <li><a href='#'>A1</a></li>
                <li><a href='#'>A2</a></li>
                <li><a href='#'>A3</a></li>
                <li><a href='#'>A4</a></li>
            </ul>
        </div>
        <div class="col-sm-4">
            <h4>آخرین اخبار</h4>
            <ul>
                <li><a href='#'>NEWS1</a></li>
                <li><a href='#'>NEWS2</a></li>
                <li><a href='#'>NEWS3</a></li>
                <li><a href='#'>NEWS4</a></li>
            </ul>
        </div>
        <div class="col-sm-4">
            <h4>آخرین نظرات</h4>
            <ul>
                <li><a href='#'>COMMENT1</a></li>
                <li><a href='#'>COMMENT2</a></li>
                <li><a href='#'>COMMENT3</a></li>
                <li><a href='#'>COMMENT4</a></li>
            </ul>
        </div>
    </div>
    <br>
    <span>&copy; Copy Right . All right reserved for traffic booster . 2017</span>
</div>

    <div id='mobile_menu_bar'>
        <ul>
            @yield('main_menu')
        </ul>
    </div>
    <a href='#'><div id='mobile_menu_bar_close'>
        &times
    </div></a>
    <div id="mobile_header_menu">
        <div id="mobile_header_menu_button">
        &#9776;
        </div>
    </div>
<div id='mobile_menu_bar_cover'></div>
    <div id='main_menu_bar_float'>
        <ul>
            @yield('main_menu')
        </ul>
    </div>

    <script src="{{ asset('jquery/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('bootstrap/css/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/script01.js')}}"></script>
    <script src='https://www.google.com/recaptcha/api.js?hl=fa'></script>
    @yield('page_footer')

    </div>
    @yield('page_body2',' ')
</body>

</html>
