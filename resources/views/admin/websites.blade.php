
@extends('../theme')

@section('page_title','افزایش ترافیک سایت - مدیریت وبسایت ها')

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
                <th>عنوان </th>
                <th>آدرس</th>
                <th>صاحب</th>
                <th>امتیاز</th>
                <th>مشاهدات</th>
                <th>پسند ها</th>
                <th>اصلاح مشخصات</th>
                <th>حزف</th>
                <th>حزف تمام سایت های کاربر</th>
            </tr>
        </thead>
        <tbody>
            @foreach($websites as $w)
            <tr>
                <td>{{$w->id}}</td><td>{{$w->title}}</td><td><a href="{{$w->url}}" target="_blank">{{$w->url}}</a></td><td>{{$w->user->username}}</td><td>{{$w->pointpervisit}}</td><td>{{$w->views}}</td><td>{{$w->likes}}</td>
                <td><a href="{{($app['url']->to('admin/websites/edit/')).'/'.$w->id}}">اصلاح</a></td>
                <td><a href="{{($app['url']->to('admin/websites/remove/')).'/'.$w->id}}">حزف</a></td>
                <td><a href="{{($app['url']->to('admin/websites/removeall/')).'/'.$w->id}}"> حزف همه</a></td>
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
                <li><a href="{{$app['url']->to('admin/websites')}}?page={{$i}}">{{$i+1}}</a></li>
            @endif
        @endfor
    </ul>
</div>
@endsection

