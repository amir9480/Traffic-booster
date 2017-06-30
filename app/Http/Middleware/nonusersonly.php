<?php

namespace Test\Http\Middleware;

use Closure;
use \Illuminate\Http\Request;
use \Test\UserManagment;

class nonusersonly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->cookie('userid')!=null||$request->cookie('usersession')!=null)
        {
            $user=$request->cookie('userid');
            $session=$request->cookie('usersession');
            $m=UserManagment::where('username',$user)->first();
            if($m!==null&&$session==$m->usersession)
            {
                return redirect('/websites');
            }
        }
        return $next($request);
    }
}
