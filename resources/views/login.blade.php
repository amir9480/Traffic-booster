@extends('theme')

@section('page_title','افزایش ترافیک سایت - ورود کاربران')


@section('page_head')

@endsection

@section('page_footer')

@endsection

@section('main_menu')

@section('main_menu')
    @include('menubar',['type'=>'1','active'=>'sign_in'])
@endsection

@section('page_body')
<div id='non_home_header_image' class="container">
    <div style="height: 10px;"></div>
   <h1>افزایش بازدید رایگان سایت شما</h1>
</div>
<div class='container main-content' >
<br><br>
<div style='text-align:right;'>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (isset($formerrors))
    <div class="alert alert-danger">
        <ul>
            @foreach ($formerrors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="myform_layout">
<form class="myappform form-horizontal center-block" action="{{$app['url']->to('/signin')}}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <lable class="control-label col-sm-4" for="username">نام کاربری</lable>
            <div class="col-sm-8"><input class="form-control" type="text" name="username"></div>
        </div>
        <div class="form-group">
            <lable class="control-label col-sm-4" for="password">رمز عبور</lable>
            <div class="col-sm-8"><input class="form-control" type="password" name="password"></div>
        </div>
        <div class="form-group">
          <div class="col-sm-4"></div>
          <div class="col-sm-8 g-recaptcha" data-sitekey="6LfaYSgUAAAAAFxMhXqtX6NdYW0jxFv1wnIFS1VS"></div>
        </div>
        <div class="form-group">
            <div class="col-sm-4"></div>
            <div class="col-sm-8"><input class="btn btn-default" type="submit" value="ورود"></div>
        </div>
</form>
</div>
<br><br><br><br><br><br>

</div>
</div>
@endsection
