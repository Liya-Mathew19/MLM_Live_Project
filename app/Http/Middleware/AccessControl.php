<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Redirect;

class AccessControl
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
        if(Session::has('adminsession'))
        {
            return Redirect::to('admin_dashboard');
        }
        elseif(Session::has('usersession'))
        {
            return Redirect::to('user');
        }
        else
        {
        return $next($request);
        }
    }
}
