
var btimer;
var isclosed=true;
var current_show_id=1;
var current_site_id;
var wurl;

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
                $("#website_detials").html('<span>  <a target="_blank" href="'+dr.weburl+'">'+dr.weburl+'</a> | &nbsp;'+dr.title+' &nbsp; '+dr.user_name+'</span>');
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


