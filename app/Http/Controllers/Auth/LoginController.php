<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\http\Request;
use User;
use Auth;
use App\Helper\Helper;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

     protected function authenticated(Request $request,$user)
     {
        session(['email' => $user->email]);
        session(['password' => $user->password]);
        session(['user_type' => $user->user_type]);
        $email = session('email');
        $pwd = session('password');
        $user_type = session('user_type');

        if($user->user_type=='admin')
        {
            session(['adminsession' => $user->user_type]);
            return redirect('admin_dashboard');
        }
        elseif($user->user_type=='User')
        {
            session(['usersession' => $user->user_type]);
           return redirect('user');
        }
        else
        {
            return redirect('login');
        }
     }
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
