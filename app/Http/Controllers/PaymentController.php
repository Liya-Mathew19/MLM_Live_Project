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
use Session;
use App\Helper\PaymentHelper;
use Razorpay\Api\Errors\SignatureVerificationError;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use Mail;
use App\Mail\PaymentMail;

class PaymentController extends Controller
{
    public function __construct()
    {   
        $this->middleware('user');
    }
    
    private $razorpayId = "rzp_live_y9JaZ0X1ZDH48V";
    private $razorpayKey = "xwNqDB0w09NEfh5GO6TA44Ar";

     //Main Page of Subscription 

    public function subscriptionpayment()
    {
        $acct_id=session('acct_id');
        $user_id=Auth::user()->id;
        $accounts=DB::select("select * from accounts where fk_user_id='$user_id' and status='Activated'");
        $settings=DB::select("select * from settings");
            foreach($settings as $setting)
            {
                $settings_amount=$setting->subscription_fee;
                $cgst=$setting->cgst_amount;
                $sgst=$setting->sgst_amount;
                $settings_gst=$cgst+$sgst;
                $settings_cess=$setting->cess;
                $settings_cess_flag=$setting->cess_flag;
            }
        $users=DB::select("select * from profile_completions where fk_user_id='$user_id'");
        return view('payment.subscriptionpayment',compact("acct_id","users","settings","accounts","settings_cess","settings_amount","settings_gst"));
    }


    //Payment options Page
	 public function payment_old_by_vipin(Request $request)
    {
		$user_id=Auth::user()->id;
		$no_of_term=$request->input('no_of_term');
		$accountids = $request->input('accountids');
		 if($accountids==null)
        {
            return abort(401);
        }
		$name=$request->input('name');
        
       
		$settings=DB::select("select * from settings");
		foreach($settings as $setting)
        {
            $cgst=$setting->cgst_amount;
            $sgst=$setting->sgst_amount;
            $cess=$setting->cess;
            $settings_cess_flag=$setting->cess_flag;
            $settings_gst=$cgst+$sgst;
        }
		
		
		 $subscription_fee=$setting->subscription_fee;
		
        $gst_percentage=$settings_gst;
        if(!empty(Auth::user()->gstin))
        {
            $cess_percentage="0";
        }
        else
        {
        $cess_percentage=$setting->cess;
        }
       
	    $no_of_accounts=count($accountids);
	   
        $total_subscription_fee=( $no_of_term * $subscription_fee ) * $no_of_accounts;
       
        $total_gst_amount=( $total_subscription_fee * $gst_percentage ) / 100;
        $cess_amount=($cess_percentage*$total_subscription_fee)/100;
        $total_amount=$total_subscription_fee + $total_gst_amount+$cess_amount;
		
		$account_information = implode(",",$accountids);
		//var_dump($accountids);
		$transaction= new Transactions();
		 
		$transaction->fk_user_id=$user_id;
		$transaction->subscription_fee=$total_subscription_fee;
		$transaction->sgst=$sgst;
		$transaction->cgst=$cgst;
		$transaction->cess=$cess;
		$transaction->gst=$total_gst_amount;
		$transaction->amount=$total_amount;
		$transaction->date=date('Y-m-d');
		 
		$transaction->account_information=$account_information; 
		$transaction->status="Pending";
		$transaction->save();
		
		echo $transaction->id;
	
	}
    public function payment(Request $request)
    {
        $user_id=Auth::user()->id;
        $accounts=DB::table('accounts')->where('fk_user_id', $user_id);
        $users=DB::table('profile_completions')->where('fk_user_id', $user_id);
        $wallet=DB::select("select sum(amount) as wallet_balance from wallet_transactions where fk_user_id='$user_id'");
        $acct_id=session('acct_id');

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

        $settings=DB::select("select * from settings");
        foreach($settings as $setting)
        {
            $cgst=$setting->cgst_amount;
            $sgst=$setting->sgst_amount;
            $cess=$setting->cess;
            $settings_cess_flag=$setting->cess_flag;
            $settings_gst=$cgst+$sgst;
        }
        
        $accountids = $request->input('accountids');
        
            $no_of_accounts=count($accountids);
            $newData = implode(",",$accountids);
        
       
         $total_wallet_balance= $wcredit - $wdebit;
        session(['total_wallet_balance' => $total_wallet_balance]);
        $name=$request->input('name');
        $no_of_term=$request->input('no_of_term');
        $subscription_fee=$setting->subscription_fee;
        $gst_percentage=$settings_gst;
        if(!empty(Auth::user()->gstin))
        {
            $cess_percentage="0";
        }
        else
        {
        $cess_percentage=$setting->cess;
        }
       
        $total_subscription_fee=( $no_of_term * $subscription_fee ) * $no_of_accounts;
        $sgst=$setting->sgst_rate;
        $cgst=$setting->cgst_rate;
        $cess=$setting->cess;
        $total_gst_amount=( $total_subscription_fee * $gst_percentage ) / 100;
        $cess_amount=($cess_percentage*$total_subscription_fee)/100;
        $total_amount=$total_subscription_fee + $total_gst_amount+$cess_amount;

        Session::put('subscription_details', ['name'=>$name,'no_of_term' => $no_of_term, 'subscription_fee' => $subscription_fee,
        'sgst'=>$sgst,'cess'=>$cess_percentage,'cgst'=>$cgst,'gst_percentage' => $gst_percentage,'total_subscription_fee' => $total_subscription_fee,'total_gst_amount' => $total_gst_amount,
        'total_amount' => $total_amount,'accountvalues'=> $newData,'accountids'=>$accountids,'cess_amount' => $cess_amount]);
        $subscription_data=Session::get('subscription_details');

        if($accounts==null)
        {
            return abort(401);
        }
        else
        {
            $subscription_data=Session::get('subscription_details');

            //*************************RAZORPAY PAYMENT INTEGRATION *********************************//
			$invoice=PaymentHelper::generate_invoice_number();
            $receiptId = "AFPA-SP-".$invoice;
            $api = new Api($this->razorpayId, $this->razorpayKey);
			
            $order = $api->order->create(array(
                'receipt' => $receiptId,
               'amount' => $subscription_data['total_amount'] * 100,
               //'amount' => 1 * 100,
                'currency' => 'INR'
                )
            );
           
		  // echo (json_encode((array)$order));
		   //var_dump($order);
            $orderId = $order['id'];
            Session::put('orderId',$orderId); 
            $order_id=Session::get('orderId');
           
         
         
		 // GENERATING NEXT INVOICE ID FOR SENDING MECHANT INVOICE ID TO RAZOR PAY
		 $invoice=PaymentHelper::generate_invoice_number();
		 
		$data = [
    "key"               => $this->razorpayId,
    "amount"            => $subscription_data['total_amount'] * 100,
    "name"              => Auth::user()->name,
    "description"       => "Subscription Fee",
    "image"             => "https://afpageneraltraders.com/afpa_subscription/public/vendors/mainpage/assets/img/logo.png",
    "prefill"           => [
    "name"              => Auth::user()->name,
    "email"             =>  Auth::user()->email,
    "contact"           => Auth::user()->phone,
    ],
    "notes"             => [
    "address"           => Auth::user()->address,
    "merchant_order_id" => "AFPA-".$invoice,
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $orderId,
];



$json = json_encode($data);
		 
        return view('payment.payment',compact("subscription_data","total_wallet_balance","acct_id","users","accounts",'json'));
        }
    }

public function cardpaymentverify(Request $request)
{
  
	$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
     $api = new Api($this->razorpayId, $this->razorpayKey);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
		$order_id=Session::get('orderId');
        $attributes = array(
            'razorpay_order_id' => $order_id,
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

      $razor_response=  $api->utility->verifyPaymentSignature($attributes);
	 // var_dump($razor_response);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true)
{
	$razorpay_payment_id = $request->input('razorpay_payment_id');
	DB::beginTransaction();
	
    $html = "Your payment was successful
             Payment ID: {$_POST['razorpay_payment_id']}";
	$invoice=PaymentHelper::generate_invoice_number();
    $user_id=Auth::user()->id;
    $subscription_data=Session::get('subscription_details');
    
    $accountvalues=$subscription_data['accountids'];
    $accounts=Accounts::where('fk_user_id','=',$user_id)->whereIn('acct_id',$accountvalues)->get();
    $account_count=count($accounts);
    $balance=0;
    if (Transactions::where('invoice_number', '=', $invoice)->count() > 0) 
    {
        return abort(406);
    }
    $transaction= new Transactions();
    $transaction->invoice_number=$invoice;
    $transaction->fk_user_id=$user_id;
    $transaction->subscription_fee=$subscription_data['total_subscription_fee'];
    $transaction->sgst=$subscription_data['sgst'];
    $transaction->cgst=$subscription_data['cgst'];
    $transaction->cess=$subscription_data['cess'];
    $transaction->gst=$subscription_data['total_gst_amount'];
    $transaction->amount=$subscription_data['total_amount'];
    $transaction->date=date('Y-m-d');
    $transaction->paid_from="Card";
    $transaction->reference_no=$razorpay_payment_id;
    $transaction->status="Paid";
    $transaction->save();
    $transactions=DB::select("select * from transactions where fk_user_id = '$user_id'");

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
        $wallet->fk_user_id=$user_id;
        $wallet->amount=$balance;
        $wallet->date=date('Y-m-d');
        $wallet->type="Credit";
        $wallet->remarks="Transferred from payment balance";
        $wallet->status="Paid";
        $wallet->save();
    }
    $acct_id=session('acct_id');
      $message = "Your Payment is successfull. You can download your invoice here.";
    $data = array(
        'name'      =>  Auth::user()->name,
        'email' => Auth::user()->email,
        'message'   =>   $message,
        'id' => $trans_id
    );

 Mail::to($data['email'])->send(new PaymentMail($data));
    DB::commit();
    return redirect('/paymentsuccess')->with('status', $html);
			 
}
else
{
    $html = "Your payment failed! ". $error;
              
			 
			 
	return redirect('/subscriptionpayment')->with('error', $html);		 
}

 

}
    
//Card Payment Main Page
public function cardpayment(Request $request)
{
    DB::beginTransaction();
    if ($_POST) {
        $razorpay_payment_id = $request->input('razorpay_payment_id');
    }
    
    $invoice=PaymentHelper::generate_invoice_number();
    $user_id=Auth::user()->id;
    $subscription_data=Session::get('subscription_details');
    
    $accountvalues=$subscription_data['accountids'];
    $accounts=Accounts::where('fk_user_id','=',$user_id)->whereIn('acct_id',$accountvalues)->get();
    $account_count=count($accounts);
    $balance=0;
    if (Transactions::where('invoice_number', '=', $invoice)->count() > 0) 
    {
        return abort(406);
    }
    $transaction= new Transactions();
    $transaction->invoice_number=$invoice;
    $transaction->fk_user_id=$user_id;
    $transaction->subscription_fee=$subscription_data['total_subscription_fee'];
    $transaction->sgst=$subscription_data['sgst'];
    $transaction->cgst=$subscription_data['cgst'];
    $transaction->cess=$subscription_data['cess'];
    $transaction->gst=$subscription_data['total_gst_amount'];
    $transaction->amount=$subscription_data['total_amount'];
    $transaction->date=date('Y-m-d');
    $transaction->paid_from="Card";
    $transaction->reference_no=$razorpay_payment_id;
    $transaction->status="Paid";
    $transaction->save();
    $transactions=DB::select("select * from transactions where fk_user_id = '$user_id'");

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
        $wallet->fk_user_id=$user_id;
        $wallet->amount=$balance;
        $wallet->date=date('Y-m-d');
        $wallet->type="Credit";
        $wallet->remarks="Transferred from payment balance";
        $wallet->status="Paid";
        $wallet->save();
    }
    $acct_id=session('acct_id');
    
    DB::commit();
    return redirect('/paymentsuccess')->with('status',"Payment Successfull !!");

}




//Payment Success message page

public function paymentsuccess(Request $request)
{
    $user_id=Auth::user()->id;
   
    $accounts=DB::select("select * from accounts where fk_user_id='$user_id'");
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
    return view('payment.paymentsuccess',compact("acct_id","users","accounts"));
    }
}




    
    //Wallet Payment Confirmation Page
    public function walletconfirmation(Request $request)
    {
       
        $user_id=Auth::user()->id;
        $accounts=DB::table('accounts')->where('fk_user_id', $user_id);
        $users=DB::table('profile_completions')->where('fk_user_id', $user_id);
        $subscription_data=Session::get('subscription_details');
        $value=$subscription_data['accountvalues'];
        $amount=$subscription_data['total_amount'];
        if($accounts==null)
        {
            return abort(401);
        }
        else
        {
            $acct_id=session('acct_id');
            return view('payment.walletconfirmation',compact("amount","value","acct_id","users","accounts"));
        }
    }


    //Wallet Payment

    public function walletpayment(Request $request)
    {
        //get invoice number
        DB::beginTransaction();
        $invoice=PaymentHelper::generate_invoice_number();
        $userid=Auth::user()->id;
        $subscription_data=Session::get('subscription_details');
        $accountvalues=$subscription_data['accountids'];
        $accounts=Accounts::where('fk_user_id','=',$userid)->whereIn('acct_id',$accountvalues)->get();
        $account_count=count($accounts);
        $balance=0;
        //check if invoice not exist,if exist redirect to error page
        if (Transactions::where('invoice_number', '=', $invoice)->count() > 0) 
        {
            return abort(406);
        }
        $wallet=DB::table('wallet_transactions')->where('fk_user_id', $userid);
        $wallet_credit=DB::select("select sum(amount) as credit_amount from wallet_transactions where fk_user_id='$userid' and type='Credit'");
        $wallet_debit=DB::select("select sum(amount) as debit_amount from wallet_transactions where fk_user_id='$userid' and type='Debit'");
        
        foreach($wallet_credit as $credit)
        {
            $wcredit=$credit->credit_amount;
        }

        foreach($wallet_debit as $debit)
        {
            $wdebit=$debit->debit_amount;
        }

        $total_wallet_balance= $wcredit - $wdebit;
        //$wallet_balance=$total_wallet_balance-$subscription_data['total_amount'];
        $wallet= new WalletTransaction();
        $wallet->id=PaymentHelper::generate_wallet_id();
        $wallet->fk_user_id=$userid;
        $wallet->amount=$subscription_data['total_amount'];
        $wallet->date=date('Y-m-d');
        $wallet->type="Debit";
        $wallet->remarks="Debitted from wallet account";
        $wallet->status="Paid";
        $wallet->save();


        $transaction= new Transactions();
        $transaction->invoice_number=$invoice;
        $transaction->fk_wallet_id=$wallet->id;
        $transaction->fk_user_id=$userid;
        $transaction->subscription_fee=$subscription_data['total_subscription_fee'];
        $transaction->sgst=$subscription_data['sgst'];
        $transaction->cgst=$subscription_data['cgst'];
        $transaction->cess=$subscription_data['cess'];
        $transaction->gst=$subscription_data['total_gst_amount'];
        $transaction->amount=$subscription_data['total_amount'];
        $transaction->date=date('Y-m-d');
        $transaction->paid_from="Wallet";
        $transaction->status="Paid";
        $transaction->save();
        
        $transactions=DB::select("select * from transactions where fk_user_id = '$userid'");
        foreach($transactions as $transaction1)
        {
            $trans_id=$transaction1->transaction_id;
            $amount=$transaction1->amount;
        } 

        $balance=PaymentHelper::save_to_subscription_fee($accounts,$amount,$trans_id);
        
        $acct_id=session('acct_id');
        DB::commit();
        return redirect()->route('paymentsuccess', compact("acct_id","trans_id"));
    }


    public function payment_history()
    {
        $acct_id=session('acct_id');
        $user_id=Auth::user()->id;
        $transactions=DB::select("select * from transactions where fk_user_id='$user_id'");
        return view('payment.payment_history', compact("acct_id","transactions"));
    }
    
}
