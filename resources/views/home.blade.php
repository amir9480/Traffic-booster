{{-- ۱ ۲ ۳ ۴ ۵ ۶ ۷ ۸ ۹ ۰ --}}

@extends('theme')

@section('page_title','افزایش ترافیک سایت')

@section('page_head')

@endsection

@section('page_footer')
<script type="text/javascript">
    enable_hide_menu_on_top();
</script>
@endsection



@section('main_menu')
    @include('menubar',['type'=>'1','active'=>'home'])
@endsection

@section('page_body')
<div id='home_header_image'>
    <div style='height: 10px;'></div>
    <div id='main_menu_bar'>
        <ul>
            @include('menubar',['type'=>'1','active'=>'home'])
        </ul>
    </div>

   <h1>افزایش بازدید رایگان سایت شما</h1>
   <div id='home_header_read_more_button'><a id='home_header_read_more' href='#content_start'>بیشتر بدانید</a></div>
</div>
<a name='content_start'></a>
<br><br><br>
<div class='container'>
        <div id='the_features' style='min-height: 2000px;' class="row ">
            <div class="col-sm-4">
                <div class='home_features'>
                <h3>۱. ثبت نام کنید</h3><br>
                <span> در سایت ثبت نام کنید تا بتوانید به امکانات اختصاصی سایت دسترسی پیدا کنید</span>
                </div>
            <br>
            </div>
            <div class="col-sm-4">
                <div class='home_features_center'>
                <h3>۲. وبسایتتان را اضافه کنید</h3><br>
                    <span> سایتتون که میخواهید بازدیدش افزایش پیدا کنه از طریق گزینه ی افزودن وبسایت جدید به سایت اضافه کنید تا به دیگران نمایش داده شود</span>
                </div>
            <br>
            </div>
            <div class="col-sm-4">
                <div class='home_features'>
                <h3>۳. سایت دیگران را مشاهده کنید</h3><br>
                <span>از قسمت وبسایت ها سایت دیگران را مشاهده کرده و برای خودتان امتیاز کسب کنید</span>
                </div>
            <br>
            </div>
        </div>
            <br>
        <span class="home_text">
        <div id='text_content' class='row container'>
            <div class='col-sm-12  main-content'>
        استفاده از سایت بسیار ساده است.
        بازدید های سایت کاملا واقعی هستند . باید بدانید که شما هم یک بازدید کننده ی سایت دیگران هستید!<br>
        شما برای آنکه بتوانید سایت های خود را به دیگران نشان دهید نیاز به امتیاز دارید.
        زیرا کسانی از سایت شما بازدید خواهند کرد برای اینکارشان امتیاز کسب میکنند.
        شما میتوانید با مشاهده کردن سایت سایر کاربران برای خودتان امتیاز کسب کنید<br>

        شاید بشه این سایت رو این شکلی نامید:<br>
        وبسایتم رو ببین! وبسایتت رو میبینم!<br>
        <br>
        هم اکنون ثبت نام کنید و از امکانات سایت لذت ببرید



            </div>
        </div>

    </span>
<div style='height:30px;'>
</div>

</div>



@endsection
