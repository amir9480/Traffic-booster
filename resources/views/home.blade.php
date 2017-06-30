@extends('theme')

@section('page_title','افزایش ترافیک سایت')

@section('page_head')

@endsection

@section('page_footer')

@endsection

@section('main_menu')

@section('main_menu')
    @include('menubar',['type'=>'1','active'=>'home'])
@endsection

@section('page_body')
<div class='container'>
<div style='text-align:right;'>
<h2 >افزایش بازدید رایگان</h2>
<span style="font-size: 20pt;font-family: 'Jomhuria', cursive;">
    روش کار بسیار ساده است<br>
    با دیدن سایت دیگران امتیاز کسب کنید<br>
    با استفاده از امتیازی که دریافت کردید سایت خود را به دیگران نشان دهید و در ازای مشاهده سایتتان به آن ها امتیازتان را بدهید<br>
</span>
<a data-animation="ripple" href='{{$app['url']->to('/signup')}}' target="_self" onclick="window.location ='{{$app['url']->to('signup')}}';">ثبت نام کنید</a>
</div>
@endsection