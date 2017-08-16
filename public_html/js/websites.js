
var btimer;
var isclosed=true;
var current_show_id=1;
var current_site_id;
var wurl;
var comment_recapcha_id;

function hideVBrowser()
{
    isclosed=true;
    $('#websiteviewer_background').fadeOut();
}

function submitTest(view_token)
{
    $('#websiteviewer_browserheader').html('<center>...در حال بررسی</center>');
    $.ajax({
            url:wurl+'/websites/api/submitpoint?website_id='+current_site_id+'&view_token='+view_token,
            success:function(dr) {
                if(dr.ok===true)
                {
                    $('#websiteviewer_browserheader').html(`<center style="color:#00aa00;">`+dr.text+`<center>`);
                }
                else
                {
                    $('#websiteviewer_browserheader').html(`<center style="color:#ff0000;">`+dr.text+`<center>`);
                }
                $("#pointviewer").html('امتیاز شما : '+ dr.point );
            }
        });

}

function showTester()
{
    $('#websiteviewer_browserheader').html('<center>لطفا کمی  صبر کنید</center>');
    $.ajax({
            url:wurl+'/websites/api/requestpoint?website_id='+current_site_id,
            success:function(dr) {
                if(dr.able==false)
                {
                    alert('متاسفانه امکان ثبت امتیاز وجود ندارد!');
                    return;
                }
                $('#websiteviewer_browserheader').html(`<center>
                <img id=\"validation_image\" src=\"`+wurl+`/websites/api/current_image.png?s=`+dr.rand_session+`\">
                <button onclick=\"submitTest(\'`+dr.v0.value+`\')\">`+dr.v0.name+`</button>
                <button onclick=\"submitTest(\'`+dr.v1.value+`\')\">`+dr.v1.name+`</button>
                <button onclick=\"submitTest(\'`+dr.v2.value+`\')\">`+dr.v2.name+`</button>

                گزینه ی صحیح را انتخاب کنید
                </center>`);
            }
        });
}

function browserTimer(_reset=false)
{
    if(_reset===true)
        browserTimer.csi=current_show_id;
    if(isclosed===true|| browserTimer.csi!== current_show_id)
        return;
    btimer-=1;
    $('#websiteviewer_browserheader').html(' <center> &nbsp;لطفا&nbsp; '+parseInt(btimer)+' &nbsp;ثانیه صبر کنید&nbsp; </center> ');
    if(btimer>0)
        setTimeout(browserTimer,1000);
    else
        showTester();

}

function showwebsite(weburl,websiteid,watchonly=false)
{
    $('#websiteviewer_background').css('visibility','visible');
    $('#websiteviewer_browserheader').html('<center>...در حال بارگزاری</center>');
    $('#websiteviewer_browser').html('');
    $("#websiteviewer_browser").css('display','block');
    $("#websiteviewer_comments").css('display','none');
    $('#websiteviewer_background').fadeIn();
    $('#website_detials').html(' ');
    current_show_id++;
    isclosed=false;
    $.ajax({
            url:weburl+'/websites/api/requestvisit?website_id='+websiteid,
            success:function(dr) {
                $('#websiteviewer_browser').html('<iframe sandbox=\'\' style=\'width: 100%;height: 100%;\' src=\''+dr.weburl+'\'></iframe>');
                if(watchonly)
                {
                    $('#websiteviewer_browserheader').html('<center>'+dr.title+' <a href="'+weburl+'/websites/editwebsite?website_id='+websiteid+'"><button>اصلاح مشخصات</button></a> '+'</center>');
                }
                else if(dr.selfwebsite===true)
                {
                    $('#websiteviewer_browserheader').html('<center> این وبسایت توسط خود شما ثبت شده است </center>');
                }
                else if(dr.thepoint<=0)
                {
                    $('#websiteviewer_browserheader').html('<center> امتیازی جهت کسب کردن وجود ندارد</center>');
                }
                else if(dr.able===false)
                {
                    $('#websiteviewer_browserheader').html('<center>شما اخیرا از این سایت بازدید کرده اید . لطفا بعدا تلاش کنید</center>');
                }
                else if(dr.nopoint===true)
                {
                    $('#websiteviewer_browserheader').html('<center>متاسفانه مقدار امتیاز صاحب سایت برای دریافت امتیاز شما کافی نیست</center>');
                }
                else
                {
                    $('#websiteviewer_browserheader').html('<center> &nbsp;لطفا&nbsp; '+parseInt(dr.timer)+'&nbsp;ثانیه صبر کنید &nbsp;</center>');
                    setTimeout(function(){browserTimer(true);},1000);
                }
                btimer=dr.timer;
                current_site_id=websiteid;
                wurl=weburl;
                if(dr.liked)
                {
                    $("#websiteviewer_likeButton").css('background-image',' url(\'/images/like_true.png\')');
                    $("#websiteviewer_likeButton").attr('title','حزف پسندیدن');
                }
                else
                {
                    $("#websiteviewer_likeButton").css('background-image',' url(\'/images/like_false.png\')');
                    $("#websiteviewer_likeButton").attr('title','پسندیدن');
                }
                $("#website_detials").html('<span dir="rtl">  <a target="_blank" href="'+dr.weburl+'">'+dr.weburl+'</a> | &nbsp;'+dr.title+' &nbsp; <a target="_blank" href="'+weburl+'/user/'+dr.the_user_name+'">'+dr.user_name+'</a></span>');
            }
    });

}

function toggleLike()
{
    $.ajax({
        url:wurl+'/websites/api/togglelike?websiteid='+current_site_id,
        success:function(dr)
        {
            if(dr.website_id===current_site_id)
            {
                if(dr.liked)
                {
                    $("#websiteviewer_likeButton").css('background-image',' url(\'/images/like_true.png\')');
                    $("#websiteviewer_likeButton").attr('title','حزف پسندیدن');
                }
                else
                {
                    $("#websiteviewer_likeButton").css('background-image',' url(\'/images/like_false.png\')');
                    $("#websiteviewer_likeButton").attr('title','پسندیدن');
                }
            }
        }
    });
}



function tabShowComments()
{
    $("#websiteviewer_browser").css('display','none');
    $("#websiteviewer_comments").css('display','block');
    
    $("#websiteviewer_comments").html('<center>...در حال بارگزاری</center>');
    loadComments();
}

function tabShowWebsite()
{
    $("#websiteviewer_browser").css('display','block');
    $("#websiteviewer_comments").css('display','none');
}

function loadComments()
{
    $.ajax({
        url:wurl+'/websites/api/comments/'+current_site_id,
        success:function(dr){
            
            $('#websiteviewer_comments').html('');
            $('#websiteviewer_comments').append(`<div id="your_comment_div"><form onsubmit="postComment()" action="`+wurl+`" method="post"><input type="text" placeholder="نظر شما" id="your_comment_content"></textarea><div id="__google_recaptcha"></div><input onclick="postComment(event)" type="submit" value="ارسال نظر"></form></div>`);
            comment_recapcha_id=grecaptcha.render('__google_recaptcha',{'sitekey':'6LfaYSgUAAAAAFxMhXqtX6NdYW0jxFv1wnIFS1VS'});
            $('#websiteviewer_comments').append(`</div>`);
            for(var i=0;i<dr.comments.length;i++)
            {
                var str = '<span dir="rtl">'+dr.users[i].name + ' میگه : ' + dr.comments[i].content+'</span>';
                if(dr.ownwebsite || dr.comments[i].user_id == dr.current_user_id )
                {
                    str+='<a href="javascript:void(0)"><button onclick="deleteComment('+dr.comments[i].id+')"> حزف </button></a>';
                }
                $('#websiteviewer_comments').append('<div class="websiteviewer_thecommentblock" >'+str+'</div><br>' );
            }
        }
    });
}

function postComment(e)
{
    e.preventDefault();
    console.log(grecaptcha);
    if(grecaptcha==null)
    {
        alert('انجام نشد');
        return false;
    }
    var rr = grecaptcha.getResponse(comment_recapcha_id);
    
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
     $.ajax({
        type: "POST",
        url:wurl+'/website/api/comments/add',
        data:{'g-recaptcha-response':rr,"website_id":current_site_id,"content":$("#your_comment_content").val()},
        success:function(dr){
            if(dr.done===true)
            {
                alert('نظر شما ثبت شد');
                grecaptcha.reset();
                loadComments();
            }
            else
            {
                alert('متاسفانه مشکلی وجود دارد.نظر شما ثبت نشد. مطمئن شوید محتوای نظر شما خالی نیست و گزینه ی من یک ربات نیستم را تایید کرده اید');
                grecaptcha.reset();
            }
        },
        error: function(data)
        {
            alert('متاسفانه مشکلی در ارتباط با سرور وجود دارد. نظر شما ثبت نشده است.');
        }
    });
    alert('... لطفا کمی صبر کنید');
    return false;
}


function deleteComment(comment_id)
{
    var _con = confirm('آیا برای  حزف این نظر مطمئن هستید؟');
    if(_con==false)
        return;
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    
    $.ajax({
        url:wurl+'/website/api/comments/delete',
        type:"post",
        data:{"cid":comment_id},
        success:function(dr){
            if(dr.done==true)
                alert('حزف شد');
            else
                alert('مشکلی در حزف وجود دارد');
            loadComments();
        }
    });
}
