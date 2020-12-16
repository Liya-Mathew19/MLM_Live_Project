<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\SubscriptionPayment;
use App\Models\User;
use App\Models\Transactions;
use Illuminate\Support\Facades\Config;
use App\Helper\PaymentHelper;

class InvoicesController extends Controller
{
    public function __construct()
    {   
        $this->middleware('user');
    }
    //Listing of Invoices

    public function receiptview()
    {
        $acct_id=session('acct_id');
        $user_id=Auth::user()->id;
        $transactions=DB::select("select * from transactions where fk_user_id='$user_id'");
        return view('invoices.receiptview',compact('acct_id','transactions'));
    }


    //Get Distinct account based on transactionID

    public static function getDistinctAccountByTraniD($trans_id)
    {
        $accounts=DB::select("select distinct(fk_acct_id) from subscription_payments where fk_transaction_id='$trans_id'");
        $results=array(); 
        $settingsarray=array();
        $settings=DB::select("select * from settings");     
        foreach($accounts as $account)
        {
            $account_id= $account->fk_acct_id;
            $item= array();
            $subscriptions= static::getsubscription_by_ACC_ID_TRAND_ID($account_id,$trans_id);
            $item["qty"]=count($subscriptions);
            $duration="";
            foreach($settings as $setting)
            {
                $settingsarray['subscription_fee']=$setting->subscription_fee;
                $settingsarray['cgst_rate']=$setting->cgst_rate;
                $settingsarray['sgst_rate']=$setting->sgst_rate;
                $settingsarray['cgst_amount']=$setting->cgst_amount;
                $settingsarray['sgst_amount']=$setting->sgst_amount;
                $settingsarray['cess']=$setting->cess;
                $settingsarray['gst']=$settingsarray['cgst_amount']+$settingsarray['sgst_amount'];
            }
            
            foreach($subscriptions as $sub)
            {
                
                $item["account_id"]=$sub->fk_acct_id;
                $item["paid_date"]=$sub->paid_date;
                $item["subscription_fee"]=$sub->subscription_fee;
                $item["cgst_rate"]=$settingsarray['cgst_rate'];
                $item["sgst_rate"]=$settingsarray['sgst_rate'];
                $item["cgst_amount"]=$settingsarray['cgst_amount'];
                $item["sgst_amount"]=$settingsarray['sgst_amount'];
                $item["gst"]=$item["cgst_amount"]+$item["sgst_amount"];
                $item["cess"]=$settingsarray['cess'];
                $item["total"]=$sub->amount;
                $month=$sub->month;
                $year=$sub->year;
                $date='01'.'-'.$month.'-'.$year;
                $duration.= date("M-y",strtotime($date)). ",";
                $len=strlen($duration);
                $trimmed_duration=rtrim($duration,',');
            }
            $item["title"]="Received Subscription Fee from ".PaymentHelper::bind_account_number($account_id) ." shopping account for the month of ".$trimmed_duration;
            $results[]=$item;
           } 
           return $results;
           
    }

    
    //Getting subscription data based on accountID and transactionID

    public static function getsubscription_by_ACC_ID_TRAND_ID($account_id,$trans_id)
    {
        $subscription=DB::select("select * from subscription_payments where fk_acct_id='$account_id' and fk_transaction_id='$trans_id' ");
        return $subscription;
    }


    //View Receipt Format

    public function viewreceipt_byid($id)
    {
        $user_id=Auth::user()->id;
        $results=array();
        $user = User::whereId($user_id)->first();
        $transactions=Transactions::where('transaction_id',$id)->where('fk_user_id',$user_id)->get()->first();
        if($transactions==null)
        {
            return abort(401);
        }
        else
        {
        $subscriptions=DB::select("select * from subscription_payments where fk_transaction_id='$id'");
        foreach($subscriptions as $subscription)
        {
            $trans_id=$subscription->fk_transaction_id;
        }
        $account=static::getDistinctAccountByTraniD($trans_id);
        $results['account']=$account;
        $results['user']=$user;
        $results['transaction']=$transactions;
        return view('/invoices.viewreceipt_byid',compact('results'));
    }
        
    }
}
