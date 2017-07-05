
var btimer;
var isclosed=true;
var current_site_id;
var wurl;

function hideVBrowser()
{
    isclosed=true;
    $('#websiteviewer_background').fadeOut();
}

function submitTest(view_token)
{
    $('#websiteviewer_browserheader').html('<center>لطفا کمی  صبر کنید</center>');
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
                    alert('متاسفانه امکان ثبت امتیاز وجود ندارد. لطفا زرنگ بازی را کنار بگذارید!');
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

function browserTimer()
{
    if(isclosed===true)
        return;
    btimer-=1;
    $('#websiteviewer_browserheader').html(' <center>  لطفا'+parseInt(btimer)+'ثانیه صبر کنید   </center> ');
    if(btimer>0)
        setTimeout(browserTimer,1000);
    else
        showTester();
}

function showwebsite(weburl,websiteid)
{
    $('#websiteviewer_background').css('visibility','visible');
    $('#websiteviewer_browserheader').html('<center>در حال بارگزاری...</center>');
    $('#websiteviewer_browser').html('');
    $('#websiteviewer_background').fadeIn();
    isclosed=false;
    $.ajax({
            url:weburl+'/websites/api/requestvisit?website_id='+websiteid,
            success:function(dr) {
                $('#websiteviewer_browser').html('<iframe style=\'width: 100%;height: 100%;\' src=\''+dr.weburl+'\'></iframe>');
                if(dr.selfwebsite===true)
                {
                    $('#websiteviewer_browserheader').html('<center> این وبسایت توسط خود شما ثبت شده است </center>');
                }
                else if(dr.able===false)
                {
                    $('#websiteviewer_browserheader').html('<center>شما اخیرا از این سایت بازدید کرده اید . لطفا بعدا تلاش کنید</center>');
                }
                else 
                {
                    $('#websiteviewer_browserheader').html('<center> لطفا'+parseInt(dr.timer)+'ثانیه صبر کنید </center>');
                    setTimeout(browserTimer,1000);
                }
                btimer=dr.timer;
                current_site_id=websiteid;
                wurl=weburl;
                $("#website_detials").html('<span>  <a target="_blank" href="'+dr.weburl+'">'+dr.weburl+'</a> | '+dr.user_name+'وبسایت توسط  </span>');
            }
    });
    
}