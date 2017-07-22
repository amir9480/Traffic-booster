
@extends('../theme')

@section('page_title','افزایش ترافیک سایت - مدیریت کاربران')

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
    <table class='table table-striped'>
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام </th>
                <th>نام کاربری</th>
                <th>ایمیل</th>
                <th>امتیازات</th>
                <th>کد نشست کاربری</th>
                <th>اصلاح مشخصات</th>
                <th>حزف</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{$u->id}}</td><td>{{$u->name}}</td><td>{{$u->username}}</td><td>{{$u->email}}</td><td>{{$u->point}}</td><td>{{$u->usersession}}</td>
                <td><a href="{{($app['url']->to('admin/users/edit/')).'/'.$u->id}}">اصلاح</a></td>
                <td><a href="{{($app['url']->to('admin/users/remove/')).'/'.$u->id}}">حزف</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br><br>
    <ul class="pagination">
        @for($i=0;$i<$pagecount;$i++)
            @if($page==$i)
                <li class="active"><a href="#">{{$i+1}}</a></li>
            @else
                <li><a href="{{$app['url']->to('admin/users')}}?page={{$i}}">{{$i+1}}</a></li>
            @endif
        @endfor
    </ul>
</div>
@endsection
