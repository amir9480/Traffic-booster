<?php

namespace Test\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use Test\UserManagment;
use Illuminate\Support\Facades\Hash;

class UserManagmentController extends Controller
{ 
    public function __construct() {
        $this->middleware('nonusersonly');
    }
    


    public function signin(Request $r)
    {
        if($r->isMethod('get'))
        {
            return view('login');
        }
        $v=Validator::make($r->all(),[
            'username'=>'required|max:255|exists:user_managment,username',
            'password'=>'required|max:1024',
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
    
    public function signup(Request $r)
    {
        if($r->isMethod('get'))
        {
            return view('signup');
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
        
        return view('signup')->with([
            'successfull'=>'true'
            ]);
    }
}
