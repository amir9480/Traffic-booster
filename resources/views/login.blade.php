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
<div class='container'>
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

<form class="myappform" dir="rtl" action="{{$app['url']->to('/signin')}}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    <table class="table">
        <tr>
            <td>نام کاربری</td>
            <td> <input type="text" name="username"> </td>
        </tr>
        <tr>
            <td>رمز عبور</td>
            <td> <input type="password" name="password"> </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td> <input type="submit" value="ورود"> </td>
        </tr>
    </table>
</form>
    
</div>
</div>
@endsection