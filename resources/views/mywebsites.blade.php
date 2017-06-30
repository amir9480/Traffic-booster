@extends('theme')

@section('page_title','افزایش ترافیک سایت  - وبسایت های من')

@section('page_head')

@endsection

@section('page_footer')

@endsection

@section('main_menu')
    @include('menubar',['type'=>'2','active'=>'my_websites'])
@endsection

@section('page_body')

<div class='container'>
    <div id="points">
        <br><br>
        <span id="pointviewer">امتیاز شما  {{$point}}</span>
        <br><br>
    </div>
    
<table class='table table-striped'>
    
    @foreach($ws as $website)
        <tr>
            <td>{{$website->title}}</td><td>{{$website->pointpervisit}}</td><td> <a href="{{$app['url']->to('websites/editwebsite')}}?website_id={{$website->id}}"><button>اصلاح مشخصات</button></a></td> 
        </tr>
    @endforeach
</table>
    
    <ul class="pagination">
        @if($page>=1)
            <li><a href="{{$app['url']->to('websites/mywebsites')}}?page={{$page-1}}">قبلی</a></li>
        @endif
        @for($i=0;$i<$pagecount;$i++)
            @if($page==$i)
                <li class="active"><a href="#">{{$i+1}}</a></li>
            @else
                <li><a href="{{$app['url']->to('websites/mywebsites')}}?page={{$i}}">{{$i+1}}</a></li>
            @endif
        @endfor
        
        @if($page<$pagecount-1)
            <li><a href="{{$app['url']->to('websites/mywebsites')}}?page={{$page+1}}">بعدی</a></li>
        @endif
    </ul>
</div>

@endsection