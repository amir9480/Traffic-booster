@if($type==1)
<a class='main_menubar_link' href='{{$app['url']->to('/')}}'><li @if($active=='home')        class='active' @endif>خانه</li></a>
<a class='main_menubar_link' href='{{$app['url']->to('/signup')}}'><li @if($active=='sign_up')     class='active' @endif>ثبت نام</li></a>
<a class='main_menubar_link' href='{{$app['url']->to('/signin')}}'><li @if($active=='sign_in')     class='active' @endif>ورود</li></a>
<a class='main_menubar_link' href='{{$app['url']->to('/passremember')}}'><li @if($active=='passremember')     class='active' @endif>یادآوری رمز عبور</li></a>

@endif

@if($type==2)
<a class='main_menubar_link' href='{{$app['url']->to('/websites')}}'><li @if($active=='websites')        class='active' @endif>وبسایت ها</li></a>
<a class='main_menubar_link' href='{{$app['url']->to('/websites/addwebsite')}}'><li @if($active=='add_website')     class='active' @endif>افزودن وبسایت جدید</li></a>
<a class='main_menubar_link' href='{{$app['url']->to('/websites/mywebsites')}}'><li @if($active=='my_websites')     class='active' @endif> وبسایت های من</li></a>
<a class='main_menubar_link' href='{{$app['url']->to('/logout')}}'><li>خروج از ناحیه ی کاربری</li></a>

@endif
