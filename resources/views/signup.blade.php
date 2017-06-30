@extends('theme')

@section('page_title','افزایش ترافیک سایت - ثبت نام')

@section('page_head')

@endsection

@section('page_footer')

@endsection

@section('main_menu')

@section('main_menu')
    @include('menubar',['type'=>'1','active'=>'sign_up'])
@endsection

@section('page_body')
<div class='container'>
<div style='text-align:right;'>
@if( isset($successfull) )
    <h2>ثبت نام شما موفقیت آمیز بود  هم اکنون میتوانید وارد قسمت کاربری شوید</h2>
@else
<h2>هم اکنون ثبت نام کنید</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="myappform" dir="rtl" action="{{$app['url']->to('/signup')}}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    <table class="table">
        <tr>
            <td>نام</td>
            <td> <input type="text" name="thename" value="{{$thename or ''}}"> </td>
        </tr>
        <tr>
            <td>نام کاربری</td>
            <td> <input type="text" name="username" value="{{$username or ''}}"> </td>
        </tr>
        <tr>
            <td>ایمیل</td>
            <td> <input type="email" name="email" value="{{$email or ''}}"> </td>
        </tr>
        <tr>
            <td>رمز عبور</td>
            <td> <input type="password" name="password"> </td>
        </tr>
        <tr>
            <td>تکرار رمز عبور</td>
            <td> <input type="password" name="passwordr"> </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td> <input type="submit" value="ثبت نام"> </td>
        </tr>
    </table>
</form>
@endif
</div>
</div>
@endsection