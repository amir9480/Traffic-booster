@extends('theme')

@section('page_title','افزایش ترافیک سایت  - وبسایت ها')

@section('page_head')

@endsection

@section('page_footer')
<script src="js/websites.js"></script>
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
        <div id='websiteviewer_closeButton'><button onclick="hideVBrowser()">X</button></div>
        <div id='websiteviewer_browser'><iframe style='width: 100%;height: 100%;' src=''></iframe></div>
        <div id="website_detials">By:</div>
    </div>
</div>

<div class='container'>
    <div id="points">
        <br><br>
        <span id="pointviewer">امتیاز شما  {{$point}}</span>
        <br><br>
    </div>
    
<table class='table table-striped'>
    
    @foreach($ws as $website)
        <tr>
        <td>{{$website->title}}</td><td>{{$website->pointpervisit}}</td><td><button onclick="showwebsite('{{$app['url']->to('/')}}',{{$website->id}} )">مشاهده</button></td> 
        </tr>
    @endforeach
</table>
    
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
</div>

@endsection