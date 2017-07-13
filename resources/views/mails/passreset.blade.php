<html>
<head>

</head>
<body>
  <h1><br />{{$name}}<br /></h1>
  <h1> عزیز جهت تغییر رمز عبور خودتان بر روی لینک زیر کلیک کنید </h1><br>
  <span> نام کاربری شما در سایت<br>
  {{$username}}<br>
    </span><br />
  <a target="_blank" href="{{$app['url']->to('passreset')}}?userid={{$user_id}}&usersession={{$user_session}}">لینک تغییر رمز عبور</a>
</body>
</html>
