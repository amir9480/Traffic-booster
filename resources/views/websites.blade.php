@extends('theme')

@section('page_title','افزایش ترافیک سایت  - وبسایت ها')

@section('page_head')

@endsection

@section('page_footer')
    <script src="{{ asset('js/websites.js')}}"></script>
@endsection

@section('main_menu')
    @include('menubar',['type'=>'2','active'=>'websites'])
@endsection

@section('page_body')

<div id='websiteviewer_background'>
    <div id='websiteviewer_window'>
        <div class='container' id='websiteviewer_browserheader'>
            Hello
            <button>button1</button>
            <button>button2</button>
            <button>button3</button>

        </div>
        <a href="#"><div id='websiteviewer_closeButton'><button onclick="hideVBrowser()">X</button></div></a>
        <div id='websiteviewer_tabs'><button id="websiteviewer_button_website" onclick="tabShowWebsite()">سایت</button><button id="websiteviewer_button_comments"  onclick="tabShowComments()">نظرات</button></div>
        <div id='websiteviewer_comments'>نظرات سایت</div>
        <div id='websiteviewer_browser'><iframe style='width: 100%;height: 100%;' src=''></iframe></div>
        <a href="#"><div title="پسندیدن" id='websiteviewer_likeButton' onclick="toggleLike()"></div></a>
        <div id="website_detials">By:</div>
    </div>
</div>

<div id='non_home_header_image' class="container">
    <div style="height: 10px;"></div>
   <h1>افزایش بازدید رایگان سایت شما</h1>
</div>
<div class='container main-content'>
    <div id="points">
        <br><br>
        <span id="pointviewer">امتیاز شما : {{$point}}</span>
        <br><br>
    </div>

<table class='table table-striped'>
    <thead>
    <td>عنوان سایت</td>
    <td>امتیاز</td>
    <td>مشاهده</td>
    </thead>
    <tbody>
    @foreach($ws as $website)
        <tr>
        <td>{{$website->title}}</td><td>{{$website->pointpervisit}}</td><td><a href="javascript:void(0)"><button onclick="showwebsite('{{$app['url']->to('/')}}',{{$website->id}} )">مشاهده</button></a></td>
        </tr>
    @endforeach
    </tbody>
</table>
@if($pagecount>1)
    <ul class="pagination">
        @if($page>=1)
            <li><a href="{{$app['url']->to('websites')}}?page={{$page-1}}&rs={{$rs}}">قبلی</a></li>
        @endif
        @for($i=0;$i<$pagecount;$i++)
            @if($page==$i)
                <li class="active"><a href="#">{{$i+1}}</a></li>
            @else
                <li><a href="{{$app['url']->to('websites')}}?page={{$i}}&rs={{$rs}}">{{$i+1}}</a></li>
            @endif
        @endfor

        @if($page<$pagecount-1)
            <li><a href="{{$app['url']->to('websites')}}?page={{$page+1}}&rs={{$rs}}">بعدی</a></li>
        @endif
    </ul>
@endif
</div>

@endsection
