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
<div class='container'>
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

<form class="myappform" dir="rtl" action="{{$app['url']->to('/websites/editwebsite')}}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="website_id" value="{{$website_id}}">
    <table class="table">
        <tr>
            <td>عنوان سایت</td>
            <td> <input type="text" name="webtitle" value="{{$webtitle or ''}}"> </td>
        </tr>
        <tr>
            <td>آدرس سایت</td>
            <td> <input type="url" name="weburl" value="{{$weburl or ''}}"> </td>
        </tr>
        <tr>
            <td>امتیاز به ازای هر بازدید</td>
            <td> <input type="number" name="ppv" value="{{$ppv or '10'}}"> </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td> <input type="submit" value="بروزرسانی سایت"> </td>
        </tr>
    </table>
</form>
@endif
</div>
</div>
@endsection

