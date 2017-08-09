<?php

namespace Test;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;


class UserManagment extends Model
{
    protected $table='user_managment';
    protected $primary='id';

    protected $fillable = array('name','username','email','password','point','usersession','is_admin');
    public $timestamps=true;


    public function websites()
    {
        return $this->hasMany('Test\Websites','user_id','id');
    }

    public function views()
    {
        return $this->hasMany('Test\WebsiteViews','user_id','id');
    }

    public function likes()
    {
        return $this->hasMany('Test\Likes','user_id','id');
    }
    public function comments()
    {
        return $this->hasMany('Test\Comment','user_id','id');
    }



    public static function getCurrentUser(Request $request)
    {
        if($request->cookie('userid')===null||$request->cookie('usersession')===null)
        {
            return null;
        }
        $user=$request->cookie('userid');
        $session=$request->cookie('usersession');
        $m=UserManagment::where('username',$user)->first();
        if($m===null||$session!=$m->usersession)
        {
            return null;
        }
        $request->session()->put('usersession',$session);
        return $m;
    }
}
