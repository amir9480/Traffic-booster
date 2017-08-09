<?php

namespace Test\Http\Controllers;

use Illuminate\Http\Request;


require_once(app_path().DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'recaptcha'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'autoload.php');

use ReCaptcha\ReCaptcha;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

use Test\UserManagment;
use Test\Websites;
use Test\Comments;

class WebAdmin extends Controller
{
    public function __construct()
    {
        $this->middleware('adminsonly');
        
    }
    
    public function home(Request $r)
    {
        return view('admin.home');
    }
    
    public function users(Request $r)
    {
        $page = 0;
        if($r->exists('page'))
            $page=$r->input('page');
        $users = UserManagment::orderBy('created_at','desc')->limit(20)->offset(20*$page)->get();
        $pcount = UserManagment::count();
        
        return view('admin.users')->with([
            'users'=>$users,
            'pagecount'=>((int)($pcount/20))+1,
            'page'=>$page
        ]);
    }
    
    public function showUserEdit(Request $r,$userid)
    {
        $u = UserManagment::where('id',$userid)->first();
        if($u===null)
            return redirect()->back();
        if($r->isMethod('get'))
        {
        return view('admin.useredit')->with([
            'user'=>$u
        ]);
        }
        
        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('admin.useredit')->with([
                  'user'=>$u,
                  '_r_error'=>true,
                  'formerrors'=>['  لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید ']
                  ]);
        }
        
        $u->name = $r->input('thename');
        $u->username = $r->input('username');
        $u->email = $r->input('email');
        $u->point = $r->input('points');
        $u->save();
        
        return view('admin.useredit')->with([
            'user'=>$u,
            'successfull'=>true
        ]);
        
    }
    
    public function showUserRemove(Request $r,$userid)
    {
        $u = UserManagment::where('id',$userid)->first();
        if($u===null)
            return redirect()->back();
        if($r->isMethod('get'))
        {
        return view('admin.userremove')->with([
            'user'=>$u
        ]);
        }
        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('admin.userremove')->with([
                    'user'=>$u,
                  '_r_error'=>true,
                  'formerrors'=>['  لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید ']
                  ]);
        }
        
        UserManagment::destroy($u->id);
        return view('admin.userremove')->with([
            'user'=>$u,
            'successfull'=>true
        ]);
    }
    
    
    public function websites(Request $r)
    {
        $page = 0;
        if($r->exists('page'))
            $page=$r->input('page');
        $websites = Websites::orderBy('created_at','desc')->offset(20*$page)->limit(20)->get();
        $pcount = Websites::count();
        
        return view('admin.websites')->with([
            'websites'=>$websites,
            'pagecount'=>((int)($pcount/20))+1,
            'page'=>$page
        ]);
    }
    
    public function showWebEdit(Request $r , $websiteid )
    {
        $w = Websites::where('id',$websiteid)->first();
        if($w===null)
            return redirect()->back();
        if($r->isMethod('get'))
        {
        return view('admin.websiteedit')->with([
            'website'=>$w
        ]);
        }
        
        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('admin.websiteedit')->with([
                  'website'=>$w,
                  '_r_error'=>true,
                  'formerrors'=>['  لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید ']
                  ]);
        }
        
        $w->title=$r->input('webtitle');
        $w->url = $r->input('url');
        $w->pointpervisit = $r->input('ppv');
        $w->views =  $r->input('views');
        $w->save();
        
        return view('admin.websiteedit')->with([
            'website'=>$w,
            'successfull'=>true
        ]);
    }
    
    public function showWebRemove(Request $r,$websiteid)
    {
        $w = Websites::where('id',$websiteid)->first();
        if($w===null)
            return redirect()->back();
        if($r->isMethod('get'))
        {
        return view('admin.websiteremove')->with([
            'website'=>$w
        ]);
        }
        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('admin.websiteremove')->with([
                    'website'=>$w,
                  '_r_error'=>true,
                  'formerrors'=>['  لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید ']
                  ]);
        }
        
        Websites::destroy($w->id);
        return view('admin.websiteremove')->with([
            'website'=>$w,
            'successfull'=>true
        ]);
    }
    
    public function showWebAllRemove(Request $r,$websiteid)
    {
        $w = Websites::where('id',$websiteid)->first();
        if($w===null)
            return redirect()->back();
        $u = $w->user;
        if($r->isMethod('get'))
        {
        return view('admin.websiteremoveall')->with([
            'website'=>$w
        ]);
        }
        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('admin.websiteremoveall')->with([
                    'website'=>$w,
                  '_r_error'=>true,
                  'formerrors'=>['  لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید ']
                  ]);
        }
        
        Websites::where('user_id',$u->id)->delete();
        
        return view('admin.websiteremoveall')->with([
            'website'=>$w,
            'successfull'=>true
        ]);
    }
    
    public function showHashCreator(Request $r)
    {
        if($r->isMethod('get'))
        {
          return view('admin.hashcreator');
        }
        
        $hashed= Hash::make($r->input('data',' '));
        
        
        return view('admin.hashcreator')->with([
            '_hashed'=>$hashed
        ]);
    }
    
    public function showComments(Request $r)
    {
        $page = 0;
        if($r->exists('page'))
            $page=$r->input('page');
        $comments = Comments::orderBy('created_at','desc')->offset(20*$page)->limit(20)->get();
        $pcount = Comments::count();
        $users=array();
        $websites=array();
        
        foreach($comments as $c)
        {
            $users[] = UserManagment::where('id',$c->user_id)->first()->username;
            $websites[] = Websites::where('id',$c->website_id)->first()->url;
        }
        return view('admin.comments')->with([
            'comments'=>$comments,
            'websites'=>$websites,
            'users'=>$users,
            'pagecount'=>((int)($pcount/20))+1,
            'page'=>$page
        ]);
    }
    
    public function showCommentEdit(Request $r , $commentid )
    {
        $c = Comments::where('id',$commentid)->first();
        if($c===null)
            return redirect()->back();
        if($r->isMethod('get'))
        {
        return view('admin.commentedit')->with([
            'comment'=>$c
        ]);
        }
        
        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('admin.commentedit')->with([
                  'comment'=>$c,
                  '_r_error'=>true,
                  'formerrors'=>['  لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید ']
                  ]);
        }
        
        $c->content=$r->input('thecomment');
        $c->save();
        
        return view('admin.commentedit')->with([
            'comment'=>$c,
            'successfull'=>true
        ]);
    }
    
    public function showCommentRemove(Request $r,$commentid)
    {
        $c = Comments::where('id',$commentid)->first();
        if($c===null)
            return redirect()->back();
        if($r->isMethod('get'))
        {
        return view('admin.commentremove')->with([
            'comment'=>$c
        ]);
        }
        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('admin.commentremove')->with([
                    'comment'=>$c,
                  '_r_error'=>true,
                  'formerrors'=>['  لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید ']
                  ]);
        }
        
        Comments::destroy($c->id);
        return view('admin.commentremove')->with([
            'comment'=>$c,
            'successfull'=>true
        ]);
    }
    
    
    public function showCommentAllRemove(Request $r,$commentid)
    {
        $c = Comments::where('id',$commentid)->first();
        if($c===null)
            return redirect()->back();
        $u = $c->user;
        if($u==null)
            return redirect()->back();
        if($r->isMethod('get'))
        {
        return view('admin.commentsremoveall')->with([
            'comment'=>$c
        ]);
        }
        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('admin.commentsremoveall')->with([
                    'comment'=>$c,
                  '_r_error'=>true,
                  'formerrors'=>['  لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید ']
                  ]);
        }
        
        Comments::where('user_id',$u->id)->delete();
        
        return view('admin.commentsremoveall')->with([
            'comment'=>$c,
            'successfull'=>true
        ]);
    }
    
}
