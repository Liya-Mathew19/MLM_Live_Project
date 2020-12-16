<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfileCompletion;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Mail\DemoEmail;
use Mail;

class VerifyemailController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    
    public function emailverification()
    {
        $acct_id=session('acct_id');
        return view('user.emailverification',compact("acct_id"));
    }
    //Generate random OTP

    public function generateOTP()
    {
        $otp = mt_rand(1000,9999);
        return $otp;
    }

      //Verifying OTP matches or not

    public function verifyemail(Request $request)
    {
        $acct_id=session('acct_id');
        $customer=User::all();
        $new_otp=request('otp');
        $view = User::where([['email',"=",Auth::user()->email ]])->get();
        foreach ($view as $user)
        {
            $OTP=$user->email_otp;
        }
       
            if($OTP == $new_otp)
            {
                //Updating user_status and phone_status as "Verified.
        $profile=ProfileCompletion::where([['fk_user_id',"=",Auth::user()->id]])->get();
        foreach ($profile as $p)
        {
            $p= $p->percentage;
        }
                DB::table('users')->where([['email',"=",Auth::user()->email ]])->update(['email_status' => "Verified",'user_status'=>"Verified"]);
               DB::table('profile_completions')->where([['fk_user_id',"=",Auth::user()->id ]])->update(['percentage' => $p+10]);
                return redirect('/user')->with('success', 'Email Verified!!'); 
            }
            else
            {
                return redirect()->back()->with('error', 'OTP does not match!!'); 
            }
    }

        //Resend a new OTP when requested

    public function resendemailOtp(Request $request)
    {
        $acct_id=session('acct_id');
        $view = User::where([['email',"=",Auth::user()->email ]])->get();
        $otp = $this->generateOTP();
        foreach ($view as $user)
        {
            $user->email_otp=$otp;
            $status=$user->email_status;
        }
        if($status=="Progress"){
            DB::table('users')->where([['email',"=",Auth::user()->email ],['email_status',"=" ,$status]])->update(['email_otp' => $otp]);
            
            $data = array(
                'name'      =>  Auth::user()->name,
                'email' => Auth::user()->email,
                'otp'   =>   $otp
            );
    
         Mail::to($data['email'])->send(new DemoEmail($data));
            
            return redirect('/emailverification')->with('success', 'An OTP has send to your mail successfully!!!'); 
        }
        else{
            return redirect('/emailverification')->with('error', 'OTP already verified!!'); 
        }
        
     }
}
