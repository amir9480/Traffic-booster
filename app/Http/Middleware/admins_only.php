<?php

namespace Test\Http\Middleware;

use Closure;
use Test\UserManagment;

class admins_only
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $u=null;
        if(($u=UserManagment::getCurrentUser($request))===null)
            return redirect('/');
        if($u->is_admin===false)
            return redirect('/');
        return $next($request);
    }
}
