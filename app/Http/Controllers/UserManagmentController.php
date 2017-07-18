<?php


namespace Test\Http\Controllers;

use Test\Mail\RegisterWelcome;
use Test\Mail\PassReset;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Redirector;

use Validator;

use Test\UserManagment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

require_once(app_path().DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'recaptcha'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'autoload.php');

use ReCaptcha\ReCaptcha;



class UserManagmentController extends Controller
{
    public function __construct() {
        $this->middleware('nonusersonly');
    }


    // این دستور برای زمان ورود میباشد
    public function signin(Request $r)
    {

        // اگه هنوز دیتایی فرستاده نشده باشه این دستور فراخوانی بشه
        if($r->isMethod('get'))
        {
            return view('login');
        }
        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('login')->with([
                  'formerrors'=>['  لطفا بر روی گزینه ی من یک ربات نیستم کلیک کنید ']
                  ]);
        }


        $v=Validator::make($r->all(),[
            'username'=>'required|max:255|exists:user_managment,username',
            'password'=>'required|max:1024'
        ]);
        if($v->fails())
        {
            return view('login')->withErrors($v);
        }

        $u= UserManagment::where('username',$r->input('username'))->first();
        if(Hash::check($r->input('password'),$u->password)==false)
        {
            return view('login')->with([
                    'formerrors'=>['رمز عبور اشتباه است']
                    ]);
        }
        $u->usersession=str_random(16);
        $u->save();
        return redirect('/websites')->withCookie('usersession',$u->usersession)->withCookie('userid',$u->username);
    }

    // جهت ثبت نام
    public function signup(Request $r)
    {
        if($r->isMethod('get'))
        {
            return view('signup');
        }


        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('signup')->with([
            'thename'=>$r->input('thename',' '),
            'username'=>$r->input('username',' '),
            'email'=>$r->input('email',' '),
            '_r_error'=>true
                ]);
        }

        $v=Validator::make($r->all(),[
            'thename'=>'required|max:255',
            'username'=>'required|max:255|unique:user_managment,username',
            'email'=>'required|max:1024|unique:user_managment,email',
            'password'=>'required|max:1024',
            'passwordr'=>'required|same:password'
        ]);
        if($v->fails())
        {
            return view('signup')->withErrors($v)->with([
                'thename'=>$r->input('thename'),
                'username'=>$r->input('username'),
                'email'=>$r->input('email')
                    ]);
        }

        UserManagment::create([
            'name'=>$r->input('thename'),
            'username'=>$r->input('username'),
            'email'=>$r->input('email'),
            'password'=>Hash::make($r->input('password'))
        ]);

        Mail::to($r->input('email'))->send(new RegisterWelcome($r->input('thename')));

        return view('signup')->with([
            'successfull'=>'true'
            ]);
    }

    public function passwordReset(Request $r)
    {
        if($r->isMethod('get'))
        {
            if($r->exists('userid')===false || $r->exists('usersession')===false)
                return abort(404);
            $v=Validator::make($r->all(),[
                'userid'=>'numeric'
            ]);
            if($v->fails())
                return abort(404);

            $u = UserManagment::where('id',$r->input('userid'))->first();
            if($u->usersession != $r->input('usersession'))
                return abort(404);
            $r->session()->put('__userid',$r->input('userid'));
            $r->session()->put('__usersession',$r->input('usersession'));
            return view('passwordreset');
        }

        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
          return view('passwordreset')->with([
            '_r_error'=>true
                ]);
        }

        $v=Validator::make($r->all(),[
            'password'=>'required|max:1024',
            'passwordr'=>'required|same:password'
        ]);
        if($v->fails())
            return view('passwordreset')->withErrors($v);

        ////////////////////////////////////////////////////
        $u=UserManagment::where('id', $r->session()->get('__userid'))->first();
        $u->password = Hash::make($r->input('password'));
        $u->usersession='0';
        $u->save();

        $r->session()->forget('__userid');
        $r->session()->forget('__usersession');

        ////////////////////////////////////////////////////
        return view('passwordreset')->with([
                'successfull'=>'true'
                ]);
    }


    public function passRemeber(Request $r)
    {
        if($r->isMethod('get'))
            return view('passremember');
        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false)
        {
            return view('passremember')->with([
            '_r_error'=>true
            ]);
        }
        //if($r->exists('email')==false)
            //retrun redirect("passremember");
        $u = UserManagment::where('email',$r->input('email'))->first();
        if($u==null)
            return view('passremember')->with([
                '_email_error'=>true
            ]);
        $u->usersession = str_random(16);
        $u->save();

        Mail::to($u->email)->send(new PassReset($u->username,$u->name,$u->id,$u->usersession) );

        return view('passremember')->with([
                'successfull'=>'true'
                ]);
    }

}
