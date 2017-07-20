
@extends('../theme')

@section('page_title','افزایش ترافیک سایت - خطا')

@section('page_head')

@endsection

@section('page_footer')

@endsection


@section('page_body')
<div id='non_home_header_image' class="container">
    <div style="height: 10px;"></div>
   <h1>افزایش بازدید رایگان سایت شما</h1>
</div>
<div class='container main-content'>
<div style='text-align:right;'>

    <h2>خطایی رخ داده است</h2><br>
    <h4><a href="{{$app['url']->to('/')}}">بازگشت به سایت</a></h4>

</div>
</div>
    <br><br><br>
</div>
@endsection
