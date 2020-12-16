<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use DB;
use Auth;

class AccountsController extends Controller
{
    public function __construct()
    {   
        $this->middleware('user');
    }
    //Accounts dashboard

    public function accountdashboard($id)
    {
        $user_id=Auth::user()->id;
        $accounts=DB::select("select * from accounts where acct_id='$id' and fk_user_id='$user_id'");
        $users=DB::select("select * from profile_completions where fk_user_id='$user_id'");
        foreach($accounts as $account)
        {
            $acct_id=$account->acct_id;
        }
        if($accounts==null)
        {
            return abort(401);
        }
        else
        {
            return view('user.accountdashboard',compact("acct_id","users","accounts")); 
        }
    }


    public function set_current_account($acct_id)
    {
        $user_id=Auth::user()->id;
        $accounts=DB::select("select * from accounts where acct_id='$id' and fk_user_id='$user_id'");
    foreach($accounts as $account)
    {
        $acct_id=$account->acct_id;
    }
    if($accounts==null)
    {
        return abort(401);
    }
    else
    {
        return view('user.userdashboard',compact("accts"));
    }
}
}
