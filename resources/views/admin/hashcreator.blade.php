
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

@if(isset($_hashed))
<div class="alert alert-info">
    <span>{{ $_hashed }}</span>
</div>
@endif

<div class="myform_layout">
<form class="myappform form-horizontal center-block" dir="rtl" action="{{$app['url']->to('/admin/hashcreator')}}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <div class="col-sm-4"><label for="data">مقدار</label></div>
            <div class="col-sm-8"><input type="text" placeholder="some thing"></div>
        </div>
        <div class="form-group">
        <div class="col-sm-12"> <input class="btn btn-default" type="submit" value="دریافت"> </div>
        </div>
</form>
</div>

</div>
@endsection
