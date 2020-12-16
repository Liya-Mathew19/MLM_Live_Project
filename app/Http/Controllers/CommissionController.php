<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use App\Models\CommissionRequests;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Helper\PaymentHelper;
use App\Models\CommissionPayments;
use Session;

use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function __construct()
    {   
        $this->middleware('user');
    }

    //Commission requests main page

    public function commission_requests()
    {
        $acct_id=session('acct_id');
        $user_id=Auth::user()->id;
        $total=0;
        $commission_requests=DB::table('commission_requests')->where('fk_user_id', $user_id)->where('status','!=','Transferred')->get();
        $transferred_commission_requests=DB::table('commission_requests')->where('fk_user_id', $user_id)->where('status','Transferred')->get();
        $total = PaymentHelper::getTotalWithdrawals($user_id);
        $wallet_balance=PaymentHelper::getCurrentWalletBalance($user_id);
        return view('invoices.commission_requests',compact('wallet_balance','acct_id','commission_requests','transferred_commission_requests','total'));
    }


    //Send commission requests

    public function send_new_commission_request(Request $request)
    {
        
        $acct_id=session('acct_id');
        $user_id=Auth::user()->id;
        $wallet_amount=DB::table('wallet_transactions')->where('fk_user_id', $user_id)->get();
        $wallet_credit=DB::select("select sum(amount) as credit_amount from wallet_transactions where fk_user_id='$user_id' and type='Credit'");
        $wallet_debit=DB::select("select sum(amount) as debit_amount from wallet_transactions where fk_user_id='$user_id' and type='Debit'");
        foreach($wallet_credit as $credit)
        {
            $wcredit=$credit->credit_amount;
        }

        foreach($wallet_debit as $debit)
        {
            $wdebit=$debit->debit_amount;
        }
        $total_wallet_balance=$wcredit-$wdebit;
        session(['total_wallet_balance' => $total_wallet_balance]);
        $amount = $request->input('amount');
        $sec_password=$request->input('password');
        if($sec_password==Auth::user()->secondary_password)
        {
        if($amount<=$total_wallet_balance)
        {
        $commission=new CommissionRequests();
        $commission->fk_user_id=$user_id;
        $commission->amount=$amount;
        $commission->date=date('Y-m-d');
        $commission->status="Requested";
        $commission->save();
        return redirect()->back()->with('status',"Request Send Successfully !!");
        }
        else
        {
            return redirect()->back()->with('error',"Insuffient wallet balance!!");
        }
    }
    else
    {
        return redirect()->back()->with('error',"Incorrect Password!!");
    }
    }





    //View transferred commission details

    public function viewcommission_byid($id)
    {
        $user_id=Auth::user()->id;
        $results=array();
        $user = User::whereId($user_id)->first();
        $commission_payment=CommissionPayments::where('fk_request_id','=',$id)->get();
        foreach($commission_payment as $payment)
        {
            $date=$payment->date;
            $voucher_no=$payment->id;
            $id=$payment->fk_user_id;
        }
        if ( $commission_payment->isEmpty() ) {
            return abort(404);
          }
        else
        {
            $results['user']=$user;
            $results['payment_date']=$date;
            $results["title"]="Commission amount paid to ".$user->name." on request.";
            $results['commission_payment']=$commission_payment;
            $results['voucher_no']=$voucher_no;
            $results['id']=$user_id;

        $acct_id=session('acct_id');
        return view('invoices.viewcommission_byid',compact('commission_payment','acct_id','results'));
        }
    }


    
    
}
