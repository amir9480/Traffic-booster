
@extends('../theme')

@section('page_title','افزایش ترافیک سایت - مدیریت نظرات')

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
                <th>نام کاربر</th>
                <th>وبسایت</th>
                <th>نظر</th>
                <th>اصلاح نظر</th>
                <th>حزف نظر</th>
                <th>حزف تمام نظرات کاربر</th>
            </tr>
        </thead>
        <tbody>
            @for($i=0;$i < count($comments);$i++)
            <tr>
                <td>{{$comments[$i]->id}}</td>
                <td>{{$users[$i]}}</td>
                <td><a target="_blank" href="{{$websites[$i]}}">{{$websites[$i]}}</a></td>
                <td>{{$comments[$i]->content}}</td>
                <td><a href="{{($app['url']->to('admin/comments/edit/')).'/'.$comments[$i]->id}}">اصلاح</a></td>
                <td><a href="{{($app['url']->to('admin/comments/remove/')).'/'.$comments[$i]->id}}">حزف</a></td>
                <td><a href="{{($app['url']->to('admin/comments/removeall/')).'/'.$comments[$i]->id}}"> حزف همه</a></td>
            </tr>
            @endfor
        </tbody>
    </table>
    <br><br>
    <ul class="pagination">
        @for($i=0;$i<$pagecount;$i++)
            @if($page==$i)
                <li class="active"><a href="#">{{$i+1}}</a></li>
            @else
                <li><a href="{{$app['url']->to('admin/comments')}}?page={{$i}}">{{$i+1}}</a></li>
            @endif
        @endfor
    </ul>
</div>
@endsection

