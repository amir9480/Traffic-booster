@if($type==1)
<li @if($active=='home')        class='active' @endif><a href='{{$app['url']->to('/')}}'>خانه</a></li>
<li @if($active=='sign_up')     class='active' @endif><a href='{{$app['url']->to('/signup')}}'>ثبت نام</a></li>
<li @if($active=='sign_in')     class='active' @endif><a href='{{$app['url']->to('/signin')}}'>ورود</a></li>

@endif

@if($type==2)
<li @if($active=='websites')        class='active' @endif><a href='{{$app['url']->to('/websites')}}'>وبسایت ها</a></li>
<li @if($active=='add_website')     class='active' @endif><a href='{{$app['url']->to('/websites/addwebsite')}}'>افزودن وبسایت جدید</a></li>
<li @if($active=='my_websites')     class='active' @endif><a href='{{$app['url']->to('/websites/mywebsites')}}'> وبسایت های من</a></li>
<li><a href='{{$app['url']->to('/logout')}}'>خروج از ناحیه ی کاربری</a></li>

@endif