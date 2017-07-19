<?php

namespace Test\Http\Controllers;

use Illuminate\Http\Request;
use Test\Likes;
use Test\UserManagment;
use Test\Websites;

class LikesController extends Controller
{
    public function __construct() {
        $this->middleware('usersonly');
    }

    public  function toggleLike(Request $r)
    {
        if($r->exists('websiteid')===false)
        {
            return redirect('/');
        }
        $u = UserManagment::getCurrentUser($r);
        $w = Websites::where('id',$r->input('websiteid'))->first();
        if($u===null||$w===null)
        {
            return redirect('/');
        }
        
        $like = Likes::where('website_id',$w->id)
                ->where('user_id',$u->id)->first();
        
        if($like===null)
        {
            Likes::create(['user_id'=>$u->id,'website_id'=>$w->id]);
            $w->likes+=1;
            $w->save();
            return response()->json([
                'website_id'=>$w->id,
                'liked'=>true
            ]);
        }
        
        
        //do dislike
        $like->delete();
        $w->likes-=1;
        $w->save();
        return response()->json([
            'website_id'=>$w->id,
            'liked'=>false
        ]);
        
    }

}
