<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\SubscriptionPayment;
use App\Models\Transactions;
use App\Models\WalletTransaction;
use App\Models\Settings;
use App\Models\Accounts;
use App\Models\User;
use Session;
use App\Helper\PaymentHelper;
use Razorpay\Api\Errors\SignatureVerificationError;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use Mail;
use App\Mail\PaymentMail;

class SubscriptionController extends Controller
{

    public function __construct()
    {   
        $this->middleware('admin');
    }

     //Main Page of Subscription 

     public function admin_subscription_payment($id)
     {
        $user=User::where('id',$id)->first();
        $accounts=DB::select("select * from accounts where fk_user_id='$id' and status='Activated'");
        $settings=Settings::first();
        $settings_amount=$settings->subscription_fee;
        $cgst=$settings->cgst_amount;
        $sgst=$settings->sgst_amount;
        $settings_gst=$cgst+$sgst;
        $settings_cess=$settings->cess;
        $settings_cess_flag=$settings->cess_flag;
        return view('payment.admin_subscription_payment',compact("user","settings","accounts","settings_cess","settings_amount","settings_gst"));
     }
 
 
     //Payment options Page
 
     public function admin_payment(Request $request,$id)
     {
        $accounts=DB::table('accounts')->where('fk_user_id', $id);
        $settings=Settings::first();
        $cgst=$settings->cgst_amount;
        $sgst=$settings->sgst_amount;
        $cess=$settings->cess;
        $settings_cess_flag=$settings->cess_flag;
        $settings_gst=$cgst+$sgst;         
        $accountids = $request->input('accountids');
        $paid_date = $request->input('date');
        $no_of_accounts=count($accountids);
        $newData = implode(",",$accountids);
        $name=$request->input('name');
        $subscription_fee=$settings->subscription_fee;
        $gst_percentage=$settings_gst;
        if(!empty(Auth::user()->gstin))
        {
            $cess_percentage="0";
        }
        else
        {
            $cess_percentage=$settings->cess;
        }
        
        $total_subscription_fee=($subscription_fee ) * $no_of_accounts;
        $sgst = $settings->sgst_rate;
        $cgst = $settings->cgst_rate;
        $cess = $settings->cess;
        $total_gst_amount =( $total_subscription_fee * $gst_percentage ) / 100;
        $cess_amount=$cess_percentage;
        $total_amount=$request->input('total_amount');
 
        Session::put('subscription_details', ['name'=>$name, 'subscription_fee' => $subscription_fee,
        'sgst'=>$sgst,'cess'=>$cess_percentage,'cgst'=>$cgst,'gst_percentage' => $gst_percentage,'total_subscription_fee' => $total_subscription_fee,'total_gst_amount' => $total_gst_amount,
        'total_amount' => $total_amount,'date' => $paid_date,'accountvalues'=> $newData,'accountids'=>$accountids,'cess_amount' => $cess_amount]);
        $subscription_data=Session::get('subscription_details');
 
        if($accounts==null)
        {
            return abort(401);
        }
        else
        {
            return view('payment.admin_payment',compact('id',"subscription_data","accounts"));
        }
    }
 
     
     //Cash Payment Confirmation Page

    public function cashconfirmation(Request $request,$id)
    {
        $user=User::find($id);
        $accounts=DB::table('accounts')->where('fk_user_id', $id);
        $subscription_data=Session::get('subscription_details');
        $value=$subscription_data['accountvalues'];
        $amount=$subscription_data['total_amount'];
        if($accounts==null)
        {
            return abort(401);
        }
        else
        {
            return view('payment.cashconfirmation',compact('user',"amount","value","accounts"));
        }
    }

    //Bank Payment Confirmation Page

    public function bankconfirmation(Request $request,$id)
    {
        $user=User::find($id);
        $accounts=DB::table('accounts')->where('fk_user_id', $id);
        $subscription_data=Session::get('subscription_details');
        $value=$subscription_data['accountvalues'];
        $amount=$subscription_data['total_amount'];
        if($accounts==null)
        {
            return abort(401);
        }
        else
        {
            return view('payment.bankconfirmation',compact("user","amount","value","accounts"));
        }
    }
 
 
    //Cash Payment
 
    public function cashpayment(Request $request,$id)
    {
        DB::beginTransaction();
        //get invoice number
        $invoice=PaymentHelper::generate_invoice_number();
        $subscription_data=Session::get('subscription_details');
        $accountvalues=$subscription_data['accountids'];
        $accounts=Accounts::where('fk_user_id','=',$id)->whereIn('acct_id',$accountvalues)->get();
        $user=User::find($id);
        $account_count=count($accounts);
        $balance=0;
        //check if invoice not exist,if exist redirect to error page
        if (Transactions::where('invoice_number', '=', $invoice)->count() > 0) 
        {
            return abort(406);
        }

        if($subscription_data['total_amount'] < $subscription_data['subscription_fee'])
        {
            $wallet= new WalletTransaction();
            $wallet->id=PaymentHelper::generate_wallet_id();
            $wallet->fk_user_id=$id;
            $wallet->amount=$subscription_data['total_amount'];
            $wallet->date=date('Y-m-d');
            $wallet->type="Credit";
            $wallet->remarks="Transferred from cash payment balance";
            $wallet->status="Paid";
            $wallet->save();
        }
        else
        {
        $transaction= new Transactions();
        $transaction->invoice_number=$invoice;
        $transaction->fk_user_id=$id;
        $transaction->subscription_fee=$subscription_data['total_subscription_fee'];
        $transaction->sgst=$subscription_data['sgst'];
        $transaction->cgst=$subscription_data['cgst'];
        $transaction->cess=$subscription_data['cess'];
        $transaction->gst=$subscription_data['total_gst_amount'];
        $transaction->amount=$subscription_data['total_amount'];
        $transaction->date=$subscription_data['date'];
        $transaction->paid_from="Cash";
        $transaction->status="Paid";
        $transaction->save();
         
        $transactions=DB::select("select * from transactions where fk_user_id = '$id'");
        foreach($transactions as $transaction1)
        {
            $trans_id=$transaction1->transaction_id;
            $amount=$transaction1->amount;
        } 
 
        $balance=PaymentHelper::save_to_subscription_fee($accounts,$amount,$trans_id);
        
        if($balance > 0)
        {
            $wallet= new WalletTransaction();
            $wallet->id=PaymentHelper::generate_wallet_id();
            $wallet->fk_user_id=$id;
            $wallet->amount=$balance;
            $wallet->date=date('Y-m-d');
            $wallet->type="Credit";
            $wallet->remarks="Transferred from cash payment balance";
            $wallet->status="Paid";
            $wallet->save();
        }
        $message = "Your Payment is successfull. You can download your invoice here.";
        $data = array(
            'name'      =>  $user->name,
            'email' => $user->email,
            'message'   =>   $message,
            'id' => $trans_id
        );

        Mail::to($data['email'])->send(new PaymentMail($data));
    }

        DB::commit();
        return redirect()->route('adminuserview',$id)->with('status','Payment Successfull !!!'); 
    }
 
 
    //Bank Payment Main Page

    public function bankpayment(Request $request,$id)
    {
        DB::beginTransaction();
        $invoice=PaymentHelper::generate_invoice_number();
        $subscription_data=Session::get('subscription_details');
        $accountvalues=$subscription_data['accountids'];
        $user=User::find($id);
        $accounts=Accounts::where('fk_user_id','=',$id)->whereIn('acct_id',$accountvalues)->get();
        $account_count=count($accounts);
        $balance=0;
        if (Transactions::where('invoice_number', '=', $invoice)->count() > 0) 
        {
            return abort(406);
        }

        if($subscription_data['total_amount'] < $subscription_data['subscription_fee'])
        {
            $wallet= new WalletTransaction();
            $wallet->id=PaymentHelper::generate_wallet_id();
            $wallet->fk_user_id=$id;
            $wallet->amount=$subscription_data['total_amount'];
            $wallet->date=date('Y-m-d');
            $wallet->type="Credit";
            $wallet->remarks="Transferred from bank payment balance";
            $wallet->status="Paid";
            $wallet->save();
            
        }

        else
        {
         
        $transaction= new Transactions();
        $transaction->invoice_number=$invoice;
        $transaction->fk_user_id=$id;
        $transaction->subscription_fee=$subscription_data['total_subscription_fee'];
        $transaction->sgst=$subscription_data['sgst'];
        $transaction->cgst=$subscription_data['cgst'];
        $transaction->cess=$subscription_data['cess'];
        $transaction->gst=$subscription_data['total_gst_amount'];
        $transaction->amount=$subscription_data['total_amount'];
        $transaction->date=$subscription_data['date'];
        $transaction->paid_from="Bank";
        $transaction->status="Paid";
        $transaction->save();
        $transactions=DB::select("select * from transactions where fk_user_id = '$id'");
 
        foreach($transactions as $transaction1)
        {
            $trans_id=$transaction1->transaction_id;
            $amount=$transaction1->amount;
        } 
         
        $balance=PaymentHelper::save_to_subscription_fee($accounts,$amount,$trans_id);
 
        if($balance > 0)
        {
            $wallet= new WalletTransaction();
            $wallet->id=PaymentHelper::generate_wallet_id();
            $wallet->fk_user_id=$id;
            $wallet->amount=$balance;
            $wallet->date=date('Y-m-d');
            $wallet->type="Credit";
            $wallet->remarks="Transferred from bank payment balance";
            $wallet->status="Paid";
            $wallet->save();
        }
        $message = "Your Payment is successfull. You can download your invoice here.";
        $data = array(
            'name'      =>  $user->name,
            'email' => $user->email,
            'message'   =>   $message,
            'id' => $trans_id
        );

        Mail::to($data['email'])->send(new PaymentMail($data));
    }
        DB::commit();
        return redirect()->route('adminuserview',$id)->with('status','Payment Successfull !!!'); 
    }    
    
    //Payment Success message page

public function paymentsuccess(Request $request,$id)
{   
    $accounts=DB::select("select * from accounts where fk_user_id='$id'");
    $users=User::find($id);
    if($accounts==null)
    {
        return abort(401);
    }
    else
    {
    return view('payment.admin_paymentsuccess',compact("users","accounts"));
    }
}
}
