<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ProfileCompletion;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helper\Helper;
use Auth;

class VerifyOtpController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    
    public function otpview()
    {
        $acct_id=session('acct_id');
        return view('user.otpview',compact("acct_id"));
    }
    //Generate random OTP

    public function generateOTP()
    {
        $otp = mt_rand(1000,9999);
        return $otp;
    }

      //Verifying OTP matches or not

    public function verifyOtp(Request $request)
    {
        $acct_id=session('acct_id');
        $customer=User::all();
        $new_otp=request('otp');
        $view = User::where([['country_code',"=",Auth::user()->country_code ],['phone',"=",Auth::user()->phone ]])->get();
        foreach ($view as $user)
        {
            $OTP=$user->phone_otp;
        }
       
            if($OTP == $new_otp)
            {
                //Updating user_status and phone_status as "Verified.
                $profile=ProfileCompletion::where([['fk_user_id',"=",Auth::user()->id]])->get();
                foreach ($profile as $p)
                {
                    $p= $p->percentage;
                }
                DB::table('users')->where([['country_code',"=",Auth::user()->country_code ],['phone',"=", Auth::user()->phone ]])->update(['phone_status' => "Verified",'user_status'=>"Verified"]);
                DB::table('profile_completions')->where([['fk_user_id',"=",Auth::user()->id ]])->update(['percentage' => $p+10]);
                return redirect('/user')->with('success', 'Mobile number Verified!!'); 
            }
            else
            {
                return redirect()->back()->with('success', 'OTP does not match!!'); 
            }
    }

        //Resend a new OTP when requested

    public function resendOtp(Request $request)
    {
        
        $acct_id=session('acct_id');
        $view = User::where([['country_code',"=",Auth::user()->country_code ],['phone',"=",Auth::user()->phone]])->get();
        $otp = $this->generateOTP();
        $message="YOUR AFPA SUBSCRIPTION PAYMENT MOBILE VERIFICATION CODE IS :".$otp;
        $mobile=Auth::user()->phone;
        foreach ($view as $user)
        {
            $user->phone_otp=$otp;
            $status=$user->phone_status;
        }
        if($status=="Progress"){
            DB::table('users')->where([['country_code',"=",Auth::user()->country_code ],['phone', "=", Auth::user()->phone ],['phone_status',"=" ,$status]])->update(['phone_otp' => $otp]);
            Helper::send_sms($mobile,$message);
            return redirect('/otpview')->with('success', 'An OTP has send to your registered mobile number successfully!!!'); 
        }
        else{
            return redirect('/otpview')->with('success', 'OTP already verified!!'); 
        }
        
     }
}
