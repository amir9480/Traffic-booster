<?php

namespace Test\Http\Controllers;

use Illuminate\Http\Request;

use Test\Websites;

use Validator;

use \Test\UserManagment;
use Test\Likes;

require_once(app_path().DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'recaptcha'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'autoload.php');

use ReCaptcha\ReCaptcha;

const recaptcha_secret = "6LfaYSgUAAAAAMQtEi8xj8hXnVWxtyzg_Z9L2hLO";
const recaptcha_site="6LfaYSgUAAAAAFxMhXqtX6NdYW0jxFv1wnIFS1VS";

class WebsitesController extends Controller
{
    public function __construct() {
        $this->middleware('usersonly');
    }
    public function __destruct() {

    }

    // افزودن یک سایت جدید
    public function addWebsite(Request $r)
    {
        if($r->isMethod('get'))
        {
            return view('addwebsite');
        }
        $recaptcha_r=new ReCaptcha(recaptcha_secret);
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('addwebsite')->with([
                  'recaptcha_error'=>'  لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید ',
                  'webtitle'=>$r->input('webtitle'),
                  'weburl'=>$r->input('weburl'),
                  'ppv'=>$r->input('ppv'),
                  ]);
        }

        $v=Validator::make($r->all(),[
            'webtitle'=>'required|max:1024',
            'weburl'=>'required|max:1024,url',
            'ppv'=>'numeric|min:1|max:1000|required',
        ]);
        if($v->fails())
        {
            return view('addwebsite')->withErrors($v)->with([
                'webtitle'=>$r->input('webtitle'),
                'weburl'=>$r->input('weburl'),
                'ppv'=>$r->input('ppv'),
                    ]);
        }

        $u=UserManagment::getCurrentUser($r);

        Websites::create([
            'title'=>$r->input('webtitle'),
            'url'=>$r->input('weburl'),
            'pointpervisit'=>$r->input('ppv'),
            'user_id'=> $u->id
        ]);

        return view('addwebsite')->with([
            'successfull'=>'true'
            ]);
    }
    
    // اصلاح مشخصات یه سایت
    public function editWebsite(Request $r)
    {
        $cu = UserManagment::getCurrentUser($r);
        $w = Websites::where('id',$r->input('website_id'))->where('user_id',$cu->id)->first();
        if($w===null)
        {
            return abort(404);
        }
        if($r->isMethod('get'))
        {
            return view('editwebsite')->with([
                'webtitle'=>$w->title,
                'weburl'=>$w->url,
                'ppv'=>$w->pointpervisit,
                'website_id'=>$r->input('website_id')
                    ]);
        }
        $recaptcha_r=new ReCaptcha(recaptcha_secret);
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('editwebsite')->with([
                  'recaptcha_error'=>'  لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید ',
                      'webtitle'=>$w->title,
                      'weburl'=>$w->url,
                      'ppv'=>$w->pointpervisit,
                      'website_id'=>$r->input('website_id')
                  ]);
        }
        $c_url=$w->url;
        $w->url='   ';
        $w->save();

        $v=Validator::make($r->all(),[
            'webtitle'=>'required|max:1024',
            'weburl'=>'required|max:1024,url',
            'ppv'=>'numeric|min:0|max:1000|required',
        ]);
        if($v->fails())
        {
            $w->url=$c_url;
            $w->save();
            return view('addwebsite')->withErrors($v)->with([
                'webtitle'=>$r->input('webtitle'),
                'weburl'=>$r->input('weburl'),
                'ppv'=>$r->input('ppv'),
                'website_id'=>$r->input('website_id')
                    ]);
        }
        $w->title=$r->input('webtitle');
        $w->url=$r->input('weburl');
        $w->pointpervisit=$r->input('ppv');
        $w->save();
        return view('editwebsite')->with([
            'successfull'=>'true'
            ]);
    }

    // مشاهده وبسایت ها
    public function showWebsites(Request $r)
    {
        if($r->has('rs')||$r->has('page'))
        {
            $v=Validator::make($r->all(),[
                'rs'=>'numeric',
                'page'=>'numeric'
                ]);
            if($v->fails())
            {
                return abort(404);
            }
        }

        $randnum= rand(0,5000);
        $ws= Websites::select(['websites.id','websites.title','websites.pointpervisit','websites.url','websites.user_id'])->
                whereRaw('websites.pointpervisit > 0 AND((SELECT user_managment.point FROM `user_managment` WHERE id = websites.user_id )>websites.pointpervisit)')->
                orderByRaw('RAND('.$r->input('rs',$randnum).')')->
                limit(20)->offset($r->input('page',0)*20);
        $wcount= Websites::select(['websites.user_id'])->
                whereRaw('(SELECT user_managment.point FROM `user_managment` WHERE id = websites.user_id )>websites.pointpervisit')->count();


        $u=UserManagment::getCurrentUser($r);

        return view('websites')->with([
            'ws'=>$ws->get(),
            'page'=>$r->input('page',0),
            'rs'=>$r->input('rs',$randnum),
            'pagecount'=>((int)($wcount/20))+1,
            'user_id'=>$u->id,
            'point'=>$u->point,
        ]);
    }

    // مشاهده وبسایت های من
    public function showMyWebsites(Request $r)
    {
        $u=UserManagment::getCurrentUser($r);
        if($r->has('page'))
        {
            $v=Validator::make($r->all(),[
                'page'=>'numeric'
                ]);
            if($v->fails())
            {
                return abort(404);
            }
        }

        $ws= Websites::where('user_id',$u->id)->
                limit(10)->offset($r->input('page',0)*10);
        $wcount= Websites::select(['websites.user_id'])->where('user_id',$u->id)->count();


        return view('mywebsites')->with([
            'ws'=>$ws->get(),
            'page'=>$r->input('page',0),
            'pagecount'=>((int)($wcount/10))+1,
            'user_id'=>$u->id,
            'point'=>$u->point
        ]);
    }
    
    
    // مشاهده وبسایت هایی که پسندیده ام
    public function showLiked(Request $r)
    {
        $u=UserManagment::getCurrentUser($r);
        if($r->has('page'))
        {
            $v=Validator::make($r->all(),[
                'page'=>'numeric'
                ]);
            if($v->fails())
            {
                return abort(404);
            }
        }

        $ws= Websites::whereIn('id',Likes::select(['website_id'])->where('user_id',$u->id)->get())->
                limit(20)->offset($r->input('page',0)*20);
        
        $wcount= Likes::where('user_id',$u->id)->count();


        return view('likedsites')->with([
            'ws'=>$ws->get(),
            'page'=>$r->input('page',0),
            'pagecount'=>((int)($wcount/20))+1,
            'user_id'=>$u->id,
            'point'=>$u->point
        ]);
    }
    
    

    // مشاهده تمام وبسایت های کاربر
    public function showUserProfile(Request $r,$user_name)
    {
        $user = UserManagment::where('username',$user_name)->first();
        if($user==null)
            return abort(404);
        
        if($r->has('page'))
        {
            $v=Validator::make($r->all(),[
                'page'=>'numeric'
                ]);
            if($v->fails())
            {
                return abort(404);
            }
        }

        $ws= Websites::where('user_id',$user->id)->
                limit(10)->offset($r->input('page',0)*10);
        $wcount= Websites::select(['websites.user_id'])->where('user_id',$user->id)->count();


        return view('userprofile')->with([
            'ws'=>$ws->get(),
            'page'=>$r->input('page',0),
            'pagecount'=>((int)($wcount/10))+1,
            'user'=>$user,
            'point'=> UserManagment::getCurrentUser($r)->point
        ]);
    }

}
