
@extends('../theme')

@section('page_title','افزایش ترافیک سایت - مدیریت')

@section('page_head')

@endsection

@section('page_footer')

@endsection

@section('main_menu')
    @include('menubar',['type'=>'2','active'=>'admin'])
@endsection

@section('page_body')
<div id='non_home_header_image' class="container">
    <div style="height: 10px;"></div>
   <h1>افزایش بازدید رایگان سایت شما</h1>
</div>
<div class='container main-content'>
    @include('admin.adminbar')
    <br><br>
@if( isset($successfull) )
    <h2>مشخصات کاربر مورد نظر اصلاح شد</h2>
@else

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(isset($_r_error)&& $_r_error===true)
    <div class="alert alert-danger">
        لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید
    </div>
@endif

<div class="myform_layout">
<form class="myappform form-horizontal center-block" dir="rtl" action="{{$app['url']->to('/admin/users/edit/').'/'.$user->id}}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <label class='control-label col-sm-4'> نام</label>
            <div class="col-sm-8"> <input class="form-control" type="text" name="thename" value="{{$thename or $user->name}}"> </div>
        </div>
        <div class="form-group">
            <label class='control-label col-sm-4'>نام کاربری</label>
            <div class="col-sm-8"> <input class="form-control" type="text" name="username" value="{{$username or $user->username}}"> </div>
        </div>
        <div class="form-group">
            <label class='control-label col-sm-4'>ایمیل</label>
            <div class="col-sm-8"> <input class="form-control" type="email" name="email" value="{{$email or $user->email}}"> </div>
        </div>
        <div class="form-group">
            <label class='control-label col-sm-4'>امتیاز</label>
            <div class="col-sm-8"> <input class="form-control" type="number" name="points" value="{{$points or $user->point}}"> </div>
        </div>
        <div class="form-group">
          <div class="col-sm-4"></div>
          <div class="col-sm-8 g-recaptcha" data-sitekey="6LfaYSgUAAAAAFxMhXqtX6NdYW0jxFv1wnIFS1VS"></div>
        </div>
        <div class="form-group">
        <div class="col-sm-4"></div>
        <div class="col-sm-8"> <input class="btn btn-default" type="submit" value="اصلاح مشخصات"> </div>
        </div>
</form>
</div>
@endif
</div>
    <br><br><br>
@endsection
