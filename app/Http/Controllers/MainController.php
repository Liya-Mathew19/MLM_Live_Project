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

class MainController extends Controller
{
     //View Receipt Format

     public function payment_receipt($id)
     {
        $id=\Crypt::decrypt($id);
        // if($id==null)
        // {
        //     return abort(401);
        // }
         $transaction=Transactions::where('transaction_id',$id)->first();
         $user_id=$transaction->fk_user_id;
         //dd($transaction);
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
         $account=InvoicesController::getDistinctAccountByTraniD($trans_id);
         $results['account']=$account;
         $results['user']=$user;
         $results['transaction']=$transactions;
         return view('/invoices.viewreceipt_byid',compact('results'));
     }
         
     }
}
