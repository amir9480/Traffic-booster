var hide_float_menu_on_top=false;

function enable_hide_menu_on_top()
{
    hide_float_menu_on_top=true;
}

// main header paralax background
$(document).scroll(function() {
var t = $(this).scrollTop();
var ww=$(window).width();
var wh=$(window).height();

if(ww>=1024)
    $("#home_header_image").css('background-position-y',(t/2.5-100).toString() + "px");
else if(wh>=768)
    $("#home_header_image").css('background-position-y',(t/2.0-50).toString() + "px");
else
    $("#home_header_image").css('background-position-y',(t/4).toString() + "px");

$("#home_header_image *").css('opacity',1.0-(2.0*t/wh));

//$("#home_header_image").css('filter','blur('+( Math.min(t/150,2.0)).toString()+'px)');
$("#home_header_image").css('filter','brightness('+(100.0-Math.min((t/wh)*100.0,70.0)).toString()+'%)');

if(ww>=752)
{
if($("#main_menu_bar_float").css('visibility')==='hidden')
{
    $("#main_menu_bar_float").hide();
    $("#main_menu_bar_float").css('visibility','visible');
}

if(hide_float_menu_on_top===true)
{
if(t>=wh-5)
    $("#main_menu_bar_float").slideDown(200);
else
    $("#main_menu_bar_float").slideUp(200);
}
else
{
    $("#main_menu_bar_float").css('visibility','visible');
    $("#main_menu_bar_float").show();
}
}

if(t+wh>=$('.home_features').offset().top)
{
    $("#the_features").css('min-height','0px');
    $(".home_features_center").fadeIn(500,function(){
        $(".home_features").fadeIn(500);
    });
}

    
});

// smoothly scroll
$('a').click(function(){
    var href = $.attr(this, 'href');
    $('html, body').animate({
        scrollTop: $('[name="' + $.attr(this, 'href').substr(1) + '"]').offset().top
    }, 800,function() {
        window.location.hash = href;
    });
    return false;
});


$('#mobile_menu_bar_close').click(function(){
    $('#mobile_menu_bar_close').css('left','-36px');
    $('#mobile_menu_bar').css('left','-50%');
    $('#mobile_menu_bar_cover').fadeOut();
    //$('#mobile_header_menu').css('left','0px');
});

$("#mobile_header_menu_button").click(function(){
    $("#mobile_menu_bar_cover").css('visibility','visible');
    $("#mobile_menu_bar_cover").hide();
    
    $('#mobile_menu_bar_close').css('left','50%');
    $('#mobile_menu_bar').css('left','0%');
    $('#mobile_menu_bar_cover').fadeIn();
    //$('#mobile_header_menu').css('left','100%');
});

$(document).ready(function(){
   //setInterval(setHomeHeaderImageHeight); 
   $("#home_header_read_more_button").hide();
   $("#home_header_read_more_button").css('visibility','visible');
   $("#home_header_read_more_button").fadeIn();
   $("#mobile_menu_bar_cover").fadeOut();
   
   $(".home_features").hide();
   $(".home_features_center").hide();
   
   
    if(hide_float_menu_on_top===false && $(window).width()>=752)
    {
        $("#main_menu_bar_float").css('visibility','visible');
        $("#main_menu_bar_float").show();
    }
});