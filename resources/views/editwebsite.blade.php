@extends('theme')

@section('page_title','افزایش ترافیک سایت - اصلاح مشخصات سایت  {{$webtitle}}')

@section('page_head')

@endsection

@section('page_footer')

@endsection

@section('main_menu')
    @include('menubar',['type'=>'2','active'=>''])
@endsection

@section('page_body')
<div id='non_home_header_image' class="container">
    <div style="height: 10px;"></div> 
   <h1>افزایش بازدید رایگان سایت شما</h1>
</div>
<div class='container main-content'>
<div style='text-align:right;'>
@if( isset($successfull) )
    <h2>وبسایت شما بروزرسانی شد</h2>
@else
<h2>وبسایت خود را بروزرسانی کنید</h2>
<span> جهت برداشتن سایت خود از صفحه بازدید ها مقدار امتیاز را به  صفر تغییر دهید<br><br></span>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class='myform_layout'>
<form class="myappform form-horizontal center-block" dir="rtl" action="{{$app['url']->to('/websites/editwebsite')}}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="website_id" value="{{$website_id}}">
    <div class='form-group'>
            <label class='control-label col-sm-4'>عنوان سایت </label>
            <div class='col-sm-8'> <input type="text" name="webtitle" value="{{$webtitle or ''}}"> </div>
        </div>
        <div class='form-group'>
            <label class='control-label col-sm-4'> آدرس سایت</label>
            <div class='col-sm-8'> <input type="url" name="weburl" value="{{$weburl or ''}}"> </div>
        </div>
        <div class='form-group'>
            <label class='control-label col-sm-4'> امتیاز به ازای هر بازدید</label>
            <div class='col-sm-8'>  <input type="number" name="ppv" value="{{$ppv or '10'}}"> </div>
        </div>
        <div class='form-group'>
            <div class='col-sm-4'></div>
            <div class='col-sm-8'>  <input class='btn btn-default' type="submit" value="ثبت سایت"> </div>
        </div>
</form>
</div>
@endif
</div>
</div>
@endsection

