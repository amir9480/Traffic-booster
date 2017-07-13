@extends('theme')

@section('page_title','افزایش ترافیک سایت - یادآوری رمز عبور')

@section('page_head')

@endsection

@section('page_footer')

@endsection

@section('main_menu')

@section('main_menu')
    @include('menubar',['type'=>'1','active'=>'passreset'])
@endsection

@section('page_body')
<div id='non_home_header_image' class="container">
    <div style="height: 10px;"></div>
   <h1>افزایش بازدید رایگان سایت شما</h1>
</div>
<div class='container main-content'>
<div style='text-align:right;'>
@if( isset($successfull) )
    <h2>لطفا ایمیل خود را چک کنید</h2>
@else
<h2>رمزتون یادتون رفته؟ ایمیلتون رو وارد کنید</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(isset($_email_error)&& $_email_error===true)
    <div class="alert alert-danger">
        ایمیل شما وجود ندارد . لطفا ثبت نام کنید
    </div>
@endif

@if(isset($_r_error)&& $_r_error===true)
    <div class="alert alert-danger">
        لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید
    </div>
@endif

<div class="myform_layout">
<form class="myappform form-horizontal center-block" dir="rtl" action="{{$app['url']->to('/passremember')}}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <label class='control-label col-sm-4'>ایمیل</label>
            <div class="col-sm-8"> <input class="form-control" type="email" name="email" value="{{$email or ''}}"> </div>
        </div>
        <div class="form-group">
          <div class="col-sm-4"></div>
          <div class="col-sm-8 g-recaptcha" data-sitekey="6LfaYSgUAAAAAFxMhXqtX6NdYW0jxFv1wnIFS1VS"></div>
        </div>
        <div class="form-group">
        <div class="col-sm-4"></div>
        <div class="col-sm-8"> <input class="btn btn-default" type="submit" value="ارسال لینک تغییر رمز"> </div>
        </div>
</form>
</div>
@endif
</div>
    <br><br><br>
</div>
@endsection
